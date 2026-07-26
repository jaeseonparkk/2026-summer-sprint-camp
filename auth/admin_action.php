<?php
session_start();
require_once "config/db.php";

// 관리자 권한 체크
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "권한 없음";
    exit;
}

$userId = $_POST['user_id'] ?? null;
$action = $_POST['action'] ?? null;

if ($userId && $action) {
    if ($action === 'suspend') {
        $sql = "UPDATE users SET role='user' WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        echo "사용자 정지 완료";
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        echo "사용자 삭제 완료";
    } else {
        echo "잘못된 요청";
    }
} else {
    echo "데이터 부족";
}
?>
