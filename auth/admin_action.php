<?php
session_start();
require_once "../config/db.php";

// 관리자 권한 확인
if (
    !isset($_SESSION['user_id']) ||
    ($_SESSION['role'] ?? '') !== 'admin'
) {
    http_response_code(403);
    exit("권한이 없습니다.");
}

$userId = $_POST['user_id'] ?? '';

// 사용자 ID 검증
if (!ctype_digit((string)$userId)) {
    exit("잘못된 사용자 ID입니다.");
}

$userId = (int)$userId;

// 현재 로그인한 관리자 자신의 계정은 삭제하지 못하게 함
if ($userId === (int)$_SESSION['user_id']) {
    exit("현재 로그인한 관리자 계정은 삭제할 수 없습니다.");
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$userId]);

header("Location: ../admin.php");
exit;
