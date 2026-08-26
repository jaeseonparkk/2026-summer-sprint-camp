<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . "/../config/db.php";

function fail(int $status, string $message): never
{
    http_response_code($status);
    exit($message);
}

if (!isset($_SESSION["user_id"])) {
    fail(401, "로그인이 필요합니다.");
}
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Allow: POST");
    fail(405, "허용되지 않은 요청 방식입니다.");
}

$fileId = filter_input(INPUT_POST, "file_id", FILTER_VALIDATE_INT);
if ($fileId === false || $fileId === null || $fileId < 1) {
    fail(400, "올바른 파일 ID가 필요합니다.");
}

$userId = (int) $_SESSION["user_id"];
$isAdmin = ($_SESSION["role"] ?? "") === "admin";
$sql = "SELECT file_name FROM uploaded_files WHERE id = ?";
$parameters = [$fileId];
if (!$isAdmin) {
    $sql .= " AND user_id = ?";
    $parameters[] = $userId;
}

$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$file = $statement->fetch(PDO::FETCH_ASSOC);
if ($file === false) {
    fail(404, "파일을 찾을 수 없습니다.");
}

$storedName = $file["file_name"];
if (!is_string($storedName) || $storedName !== basename($storedName)) {
    fail(500, "저장된 파일 경로가 올바르지 않습니다.");
}

$deleteSql = "DELETE FROM uploaded_files WHERE id = ?";
if (!$isAdmin) {
    $deleteSql .= " AND user_id = ?";
}
$deleteStatement = $pdo->prepare($deleteSql);
$deleteStatement->execute($parameters);

$uploadDir = realpath(__DIR__ . "/../uploads");
if ($uploadDir !== false) {
    $filePath = $uploadDir . DIRECTORY_SEPARATOR . $storedName;
    if (is_file($filePath) && !unlink($filePath)) {
        error_log("Could not remove uploaded file: " . $storedName);
    }
}

header("Location: file_list.php", true, 303);
exit;
