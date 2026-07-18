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
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];

// 사용자 입력을 그대로 SQL에 연결
$sql = "INSERT INTO users(username, password, name)
        VALUES('$username', '$password', '$name')";

// SQL 실행
if($pdo->query($sql)){
    header("Location: ../login.php");
    exit();
}else{
    echo "회원가입 실패";
}
?>