<?php
/*
===========================================
파일명 : auth/register_process.php
역할 : 회원가입 처리 (취약 버전)
취약점 : SQL Injection
===========================================
*/

require_once("../config/db.php");

// 사용자가 입력한 값
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    exit("아이디와 비밀번호를 입력해주세요.");
}

// 중복 아이디 확인
$check = "SELECT * FROM users WHERE username='$username'";
$result = $pdo->query($check);

if($result->rowCount() > 0){

    echo "이미 존재하는 아이디입니다.";
    exit();

}

// 사용자 입력을 그대로 SQL에 연결
$sql = "INSERT INTO users(username, password)
        VALUES('$username', '$password')";

// SQL 실행
if($pdo->query($sql)){
    header("Location: ../login.php");
    exit();
}else{
    echo "회원가입 실패";
}
?>