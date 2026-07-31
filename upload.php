<?php
/*
===========================================
파일명 : upload.php
역할 : 파일 업로드 페이지
기능 :
- 로그인한 사용자만 접근 가능
- 파일 업로드
- 업로드 결과 알림 표시
- 업로드된 파일 목록 조회
===========================================
*/

// 로그인 여부 확인
require_once("auth/auth_check.php");

// 업로드 결과 메시지
$uploadMessage = "";
$uploadMessageType = "";

// upload_vulnerable.php에서 전달한 업로드 결과 확인
if (isset($_GET["upload"])) {

    switch ($_GET["upload"]) {

        case "success":
            $uploadMessage = "파일이 성공적으로 업로드되었습니다.";
            $uploadMessageType = "success";
            break;

        case "fail":
            $uploadMessage = "파일 업로드에 실패했습니다.";
            $uploadMessageType = "error";
            break;

        default:
            $uploadMessage = "";
            $uploadMessageType = "";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>파일 업로드</title>

    <!-- 공통 CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- 공통 JavaScript -->
    <script src="js/script.js" defer></script>

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
            👤
            <?php
            echo htmlspecialchars(
                $_SESSION["username"],
                ENT_QUOTES,
                "UTF-8"
            );
            ?>님
        </span>

        <!-- 업로드 페이지 -->
        <a href="upload.php">UPLOAD</a>

        <!-- 관리자만 ADMIN 메뉴 표시 -->
        <?php if (($_SESSION["role"] ?? "") === "admin"): ?>

            <a href="admin.php">ADMIN</a>

        <?php endif; ?>

        <!-- 로그아웃 -->
        <a href="auth/logout_process.php">LOGOUT</a>

    </nav>

</header>


<!-- ===========================
     업로드 영역
=========================== -->

<main class="upload-container">

    <!-- 페이지 제목 -->
    <h1 class="upload-title">
        📂 파일 업로드
    </h1>


    <!-- ===========================
         업로드 결과 알림
    =========================== -->

    <?php if ($uploadMessage !== ""): ?>

        <div
            id="uploadAlert"
            class="upload-alert <?php
                echo htmlspecialchars(
                    $uploadMessageType,
                    ENT_QUOTES,
                    "UTF-8"
                );
            ?>"
            role="alert"
        >

            <span>
                <?php
                echo htmlspecialchars(
                    $uploadMessage,
                    ENT_QUOTES,
                    "UTF-8"
                );
                ?>
            </span>

            <button
                type="button"
                class="upload-alert-close"
                aria-label="알림 닫기"
            >
                &times;
            </button>

        </div>

    <?php endif; ?>


    <!-- ===========================
         파일 업로드 폼
    =========================== -->

    <form
        id="uploadForm"
        class="upload-form"
        action="upload/upload_vulnerable.php"
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
        id="fileListFrame"
        class="file-list-frame"
        src="upload/file_list.php"
        title="업로드된 파일 목록"
    >
    </iframe>

</main>


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