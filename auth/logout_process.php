<?php
/*
===========================================
파일명 : auth/logout_process.php
역할 : 로그아웃 처리
===========================================
*/

session_start();

// 모든 세션 변수 제거
$_SESSION = [];

// 세션 쿠키 삭제
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 세션 종료
session_destroy();

// 로그인 페이지로 이동
header("Location: ../login.php");
exit();
?>