<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo "로그인이 필요합니다.";
    exit;
}

$fileId = $_POST['file_id'] ?? null;
$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

if (!$fileId) {
    echo "파일명이 없습니다.";
    exit;
}

if ($userRole === 'admin') {
    // 관리자: 모든 파일 삭제 가능
    $stmt = $pdo->prepare("SELECT file_name FROM uploaded_files WHERE id=?");
    $stmt->execute([$fileId]);
} else {
    // 일반 사용자: 본인 파일만 삭제 가능
    $stmt = $pdo->prepare("SELECT file_name FROM uploaded_files WHERE id=? AND user_id=?");
    $stmt->execute([$fileId, $userId]);
}

$file = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$file) {
    echo "파일이 없습니다.";
    exit;
}

$filePath = "../uploads/" . $file['file_name'];

// DB 삭제
if ($userRole === 'admin') {
    $stmt = $pdo->prepare("DELETE FROM uploaded_files WHERE id=?");
    $stmt->execute([$fileId]);
} else {
    $stmt = $pdo->prepare("DELETE FROM uploaded_files WHERE id=? AND user_id=?");
    $stmt->execute([$fileId, $userId]);
}

// 실제 파일 삭제
if (file_exists($filePath)) {
    unlink($filePath);
}

echo "삭제 완료";
?>
