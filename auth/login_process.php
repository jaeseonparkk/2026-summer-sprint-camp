<?php


session_start();

require_once("../config/db.php");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 취약점 유지:
// username을 Prepared Statement 없이 SQL 문자열에 직접 삽입
$sql = "SELECT id, username, password, role
        FROM users
        WHERE username = '$username'
        LIMIT 1";

try {

    $result = $pdo->query($sql);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    // 비밀번호는 해시 검증
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