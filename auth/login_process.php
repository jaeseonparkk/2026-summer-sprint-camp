<?php

session_start();

require_once("../config/db.php");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

try {

    // Prepared Statement 사용
    // 사용자 입력값을 SQL문과 분리하여 SQL Injection 방지
    $sql = "SELECT id, username, password, role
            FROM users
            WHERE username = :username
            LIMIT 1";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':username' => $username
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 해시된 비밀번호 검증
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../index.php");
        exit;
    }

    echo "아이디 또는 비밀번호가 틀렸습니다.";

} catch (PDOException $e) {

    echo "로그인 처리 중 오류가 발생했습니다.";
}

?>