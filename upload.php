<?php
/*
===========================================
파일명 : upload.php
역할 : 시큐어 파일 업로드 페이지
기능 :
- 로그인한 사용자만 접근 가능
- 안전한 파일 업로드
- 업로드된 파일 목록 조회
===========================================
*/

// 로그인 여부 확인
require_once("auth/auth_check.php");
?>

<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="UTF-8">

    <title>파일 업로드</title>

    <!-- 공통 CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<!-- ===========================
     Header
=========================== -->

<header>

    <!-- 사이트 제목 -->
<a href="index.php" class="logo-link">
    <h1>🛡 WebShell Defense</h1>
</a>

    <nav>

        <!-- 메인 페이지 -->
        <a href="index.php">HOME</a>

        <!-- 로그인한 사용자 이름 표시 -->
        <span>
            👤 <?php echo htmlspecialchars($_SESSION['username']); ?>님
        </span>

        <!-- 업로드 페이지 -->
        <a href="upload.php">UPLOAD</a>

        <!-- 관리자만 ADMIN 메뉴 표시 -->
        <?php if($_SESSION['role'] == 'admin'): ?>
            <a href="admin.php">ADMIN</a>
        <?php endif; ?>

        <!-- 로그아웃 -->
        <a href="auth/logout_process.php">LOGOUT</a>

    </nav>

</header>


<!-- ===========================
     업로드 영역
=========================== -->

<div class="upload-container">

    <!-- 페이지 제목 -->
    <h1 class="upload-title">

        📂 파일 업로드

    </h1>

    <!-- ===========================
         파일 업로드 폼
    =========================== -->

    <form
        id="uploadForm"
        class="upload-form"
        action="upload/upload_secure.php"
        method="POST"
        enctype="multipart/form-data"
    >

        <!-- 업로드할 파일 선택 -->
        <input
            type="file"
            id="file"
            name="file"

        >

        <!-- 업로드 버튼 -->
        <button
            type="submit"
            class="upload-btn"
        >
            업로드
        </button>

    </form>


    <!-- ===========================
         업로드된 파일 목록
    =========================== -->

    <h2 class="table-title">

        📋 업로드된 파일 목록

    </h2>

    <!--
        file_list.php를 iframe으로 출력
        업로드된 파일 목록을 별도로 관리
    -->
    <iframe

        src="upload/file_list.php"

        style="
            width:100%;
            height:350px;
            border:1px solid #ddd;
            border-radius:10px;
            background:white;
        "

    >

    </iframe>

</div>


<!-- ===========================
     Footer
=========================== -->

<footer>

    <p>

        2026 Summer Sprint Camp

        <br>

        WebShell Defense Project

    </p>

</footer>

</body>

</html>
