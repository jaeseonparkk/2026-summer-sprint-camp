<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION["user_id"])) {
    exit("로그인이 필요합니다.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("잘못된 접근입니다.");
}

if (!isset($_FILES["file"])) {
    exit("파일이 선택되지 않았습니다.");
}

if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
    exit("파일 업로드 오류 코드: " . $_FILES["file"]["error"]);
}

// 최대 파일 크기 5MB
$maxFileSize = 5 * 1024 * 1024;

if ($_FILES["file"]["size"] <= 0 || $_FILES["file"]["size"] > $maxFileSize) {
    exit("파일 크기는 5MB 이하만 허용됩니다.");
}

// uploads 폴더 절대경로
$uploadDir = realpath(__DIR__ . "/../uploads");

if ($uploadDir === false) {
    exit("uploads 폴더를 찾을 수 없습니다.");
}

if (!is_writable($uploadDir)) {
    exit("uploads 폴더에 쓰기 권한이 없습니다.");
}

$fileName = basename($_FILES["file"]["name"]);
$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// 허용할 확장자
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];

if (!in_array($fileType, $allowedExtensions, true)) {
    exit("허용되지 않은 파일 확장자입니다.");
}

// 실제 파일 MIME 타입 검사
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($_FILES["file"]["tmp_name"]);

$allowedMimeTypes = [
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
    "png" => "image/png",
    "gif" => "image/gif"
];

if (
    !isset($allowedMimeTypes[$fileType]) ||
    $mimeType !== $allowedMimeTypes[$fileType]
) {
    exit("파일 확장자와 실제 파일 형식이 일치하지 않습니다.");
}

// 실제 이미지 파일인지 검사
$imageInfo = @getimagesize($_FILES["file"]["tmp_name"]);

if ($imageInfo === false) {
    exit("정상적인 이미지 파일이 아닙니다.");
}

// 파일 내부 위험 코드 검사
$fileContents = file_get_contents($_FILES["file"]["tmp_name"]);

if ($fileContents === false) {
    exit("파일 내용을 확인할 수 없습니다.");
}

$dangerousPatterns = [
    '/<\?php/i',
    '/<\?=/i',
    '/\bsystem\s*\(/i',
    '/\bexec\s*\(/i',
    '/\bshell_exec\s*\(/i',
    '/\bpassthru\s*\(/i',
    '/\beval\s*\(/i'
];

foreach ($dangerousPatterns as $pattern) {
    if (preg_match($pattern, $fileContents)) {
        exit("파일 내부에서 위험한 코드가 발견되었습니다.");
    }
}

// 저장할 최종 경로
$targetFile = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// 파일 이동
if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

    $userId = $_SESSION["user_id"];

    $sql = "INSERT INTO uploaded_files (user_id, file_name, file_type)
            VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId, $fileName, $fileType]);

    header("Location: ../upload.php?upload=success");
    exit;

} else {

    echo "<h3>파일 업로드 실패</h3>";
    echo "파일 저장 중 오류가 발생했습니다.";

    exit;
}