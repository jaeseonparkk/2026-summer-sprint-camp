<?php

session_start();

// 로그인하지 않은 경우
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();

}

// 로그인한 사용자 정보
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

?>