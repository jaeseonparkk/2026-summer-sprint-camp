<?php
/*
===========================================
파일명 : auth/login_process.php
역할 : 로그인 처리 (취약 버전)
취약점 : SQL Injection
===========================================
*/

session_start();

// DB 연결
require_once("../config/db.php");

// 로그인 폼에서 입력받은 값
$username = $_POST['username'];
$password = $_POST['password'];

// 취약한 코드 (사용자 입력을 그대로 SQL에 삽입)
$sql = "SELECT * FROM users
        WHERE username='$username'
        AND password='$password'";

// SQL 실행
$result = $pdo->query($sql);

// 로그인 성공 여부 확인
if($result->rowCount() > 0){

    $user = $result->fetch();

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: ../index.php");
    exit();

}else{

    echo "아이디 또는 비밀번호가 틀렸습니다.";

}
?>