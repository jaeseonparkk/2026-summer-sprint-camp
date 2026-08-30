<?php
declare(strict_types=1);

// 업로드한 사용자의 ID를 확인하기 위해 필요
session_start();

// 데이터베이스 연결
require_once __DIR__ . "/../config/db.php";

// 업로드 성공 또는 실패 결과를 upload.php에 전달하고 이동
function redirectWithResult(string $result): never
{
    header("Location: ../upload.php?upload=" . rawurlencode($result), true, 303);
    exit;
}

// 로그인 여부 확인
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("로그인이 필요합니다.");
}

// 파일 업로드는 POST 요청만 허용
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit("허용되지 않은 요청 방식입니다.");
}

// 업로드된 파일이 정상적으로 전달되었는지 확인
if (!isset($_FILES["file"]) || !is_array($_FILES["file"])) {
    redirectWithResult("fail");
}

$file = $_FILES["file"];

// PHP 파일 업로드 과정에서 발생한 오류 확인
if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    redirectWithResult("fail");
}

// 임시 파일 경로와 파일 크기 확인
$temporaryName = $file["tmp_name"] ?? "";
$size = filter_var($file["size"] ?? null, FILTER_VALIDATE_INT);

// 실제 HTTP 업로드 파일인지 확인하고
// 파일 크기를 1byte 이상 5MB 이하로 제한
if (!is_string($temporaryName) || !is_uploaded_file($temporaryName) ||
    $size === false || $size < 1 || $size > 5 * 1024 * 1024) {
    redirectWithResult("fail");
}

// 서버에서 허용할 이미지 MIME 타입과 저장 확장자
$allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif"];

// 파일 내용을 기준으로 실제 MIME 타입 확인
// 사용자가 입력한 파일 확장자를 그대로 신뢰하지 않음
$mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryName);

// MIME 타입이 허용된 이미지인지 확인하고
// getimagesize()를 이용해 실제 이미지 파일인지 추가 검증
if (!is_string($mimeType) || !isset($allowedTypes[$mimeType]) ||
    @getimagesize($temporaryName) === false) {
    redirectWithResult("fail");
}

// 실제 업로드 디렉토리 확인
$uploadDir = realpath(__DIR__ . "/../uploads");

// 업로드 폴더가 존재하고 쓰기 가능한지 확인
if ($uploadDir === false || !is_dir($uploadDir) || !is_writable($uploadDir)) {
    error_log("Upload directory is unavailable or not writable.");
    redirectWithResult("fail");
}

try {
    // 사용자가 입력한 원본 파일명을 사용하지 않고
    // 16바이트 난수 기반의 랜덤 파일명을 생성
    // 서버가 확인한 MIME 타입에 따라 확장자도 직접 결정
    $storedName = bin2hex(random_bytes(16)) . "." . $allowedTypes[$mimeType];
} catch (Throwable $error) {
    error_log("Could not generate an upload filename: " . $error->getMessage());
    redirectWithResult("fail");
}

// 실제 서버에 저장할 최종 파일 경로 생성
$destination = $uploadDir . DIRECTORY_SEPARATOR . $storedName;

// PHP 임시 업로드 파일을 uploads 디렉토리로 이동
if (!move_uploaded_file($temporaryName, $destination)) {
    redirectWithResult("fail");
}

try {
    // 업로드된 파일의 메타데이터를 DB에 저장
    // 실제 파일 자체는 uploads 폴더에 저장되고
    // DB에는 업로드한 사용자 ID, 저장된 파일명, MIME 타입, 업로드 시간만 기록
    $statement = $pdo->prepare(
        "INSERT INTO uploaded_files (user_id, file_name, file_type) VALUES (?, ?, ?)"
    );
    $statement->execute([(int) $_SESSION["user_id"], $storedName, $mimeType]);
} catch (Throwable $error) {
    // 파일 저장은 성공했지만 DB 저장이 실패한 경우
    // 업로드된 파일을 삭제하고 에러 로그 기록
    @unlink($destination);
    error_log("Could not save upload metadata: " . $error->getMessage());
    redirectWithResult("fail");
}

// 모든 업로드 처리가 성공하면 성공 결과 전달
redirectWithResult("success");
