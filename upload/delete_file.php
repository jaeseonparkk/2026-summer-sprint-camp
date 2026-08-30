<?php
declare(strict_types=1);

// 로그인한 사용자의 ID와 권한(role)을 사용하기 위해 필요
session_start();

// 데이터베이스 연결
require_once __DIR__ . "/../config/db.php";

// 오류 발생 시 HTTP 상태 코드와 메시지를 반환하고 실행 종료
function fail(int $status, string $message): never
{
    http_response_code($status);
    exit($message);
}

// 로그인 여부 확인
if (!isset($_SESSION["user_id"])) {
    fail(401, "로그인이 필요합니다.");
}

// 파일 삭제는 POST 요청만 허용
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Allow: POST");
    fail(405, "허용되지 않은 요청 방식입니다.");
}

// 전달받은 file_id가 올바른 정수인지 검증
$fileId = filter_input(INPUT_POST, "file_id", FILTER_VALIDATE_INT);
if ($fileId === false || $fileId === null || $fileId < 1) {
    fail(400, "올바른 파일 ID가 필요합니다.");
}

// 현재 로그인한 사용자 정보 확인
$userId = (int) $_SESSION["user_id"];
$isAdmin = ($_SESSION["role"] ?? "") === "admin";
$sql = "SELECT file_name FROM uploaded_files WHERE id = ?";
$parameters = [$fileId];

// 일반 사용자는 본인이 업로드한 파일만 조회 가능
if (!$isAdmin) {
    $sql .= " AND user_id = ?";
    $parameters[] = $userId;
}

// Prepared Statement를 사용하여 SQL Injection 위험 방지
$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$file = $statement->fetch(PDO::FETCH_ASSOC);

// 해당 파일이 없거나 삭제 권한이 없는 경우
if ($file === false) {
    fail(404, "파일을 찾을 수 없습니다.");
}

// DB에 저장된 파일명 확인
$storedName = $file["file_name"];

// 파일명에 경로 문자열이 포함되어 있는지 검사 
// basename()과 동일하지 않으면 비정상적인 경로로 판단
if (!is_string($storedName) || $storedName !== basename($storedName)) {
    fail(500, "저장된 파일 경로가 올바르지 않습니다.");
}

// DB에서 파일 정보 삭제
$deleteSql = "DELETE FROM uploaded_files WHERE id = ?";

// 일반 사용자는 자신의 파일만 삭제하도록 조건 추가
if (!$isAdmin) {
    $deleteSql .= " AND user_id = ?";
}
$deleteStatement = $pdo->prepare($deleteSql);
$deleteStatement->execute($parameters);

// 실제 업로드 파일이 저장된 디렉토리 확인
$uploadDir = realpath(__DIR__ . "/../uploads");
if ($uploadDir !== false) {

    // 삭제할 실제 파일 경로 생성
    $filePath = $uploadDir . DIRECTORY_SEPARATOR . $storedName;
    
    // 실제 파일이 존재하면 서버에서 삭제
    if (is_file($filePath) && !unlink($filePath)) {
        error_log("Could not remove uploaded file: " . $storedName);
    }
}

// 삭제 완료 후 파일 목록 페이지로 이동
header("Location: file_list.php", true, 303);
exit;
