<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . "/../config/db.php";

function redirectWithResult(string $result): never
{
    header("Location: ../upload.php?upload=" . rawurlencode($result), true, 303);
    exit;
}

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("로그인이 필요합니다.");
}
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit("허용되지 않은 요청 방식입니다.");
}
if (!isset($_FILES["file"]) || !is_array($_FILES["file"])) {
    redirectWithResult("fail");
}

$file = $_FILES["file"];
if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
    redirectWithResult("fail");
}

$temporaryName = $file["tmp_name"] ?? "";
$size = filter_var($file["size"] ?? null, FILTER_VALIDATE_INT);
if (!is_string($temporaryName) || !is_uploaded_file($temporaryName) ||
    $size === false || $size < 1 || $size > 5 * 1024 * 1024) {
    redirectWithResult("fail");
}

$allowedTypes = ["image/jpeg" => "jpg", "image/png" => "png", "image/gif" => "gif"];
$mimeType = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryName);
if (!is_string($mimeType) || !isset($allowedTypes[$mimeType]) ||
    @getimagesize($temporaryName) === false) {
    redirectWithResult("fail");
}

$uploadDir = realpath(__DIR__ . "/../uploads");
if ($uploadDir === false || !is_dir($uploadDir) || !is_writable($uploadDir)) {
    error_log("Upload directory is unavailable or not writable.");
    redirectWithResult("fail");
}

try {
    $storedName = bin2hex(random_bytes(16)) . "." . $allowedTypes[$mimeType];
} catch (Throwable $error) {
    error_log("Could not generate an upload filename: " . $error->getMessage());
    redirectWithResult("fail");
}

$destination = $uploadDir . DIRECTORY_SEPARATOR . $storedName;
if (!move_uploaded_file($temporaryName, $destination)) {
    redirectWithResult("fail");
}

try {
    $statement = $pdo->prepare(
        "INSERT INTO uploaded_files (user_id, file_name, file_type) VALUES (?, ?, ?)"
    );
    $statement->execute([(int) $_SESSION["user_id"], $storedName, $mimeType]);
} catch (Throwable $error) {
    @unlink($destination);
    error_log("Could not save upload metadata: " . $error->getMessage());
    redirectWithResult("fail");
}

redirectWithResult("success");
