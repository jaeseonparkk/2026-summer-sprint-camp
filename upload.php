<?php

// 로그인 여부 확인
// 로그인하지 않은 사용자는 업로드 페이지에 접근할 수 없음
require_once("auth/auth_check.php");

// 업로드 결과 메시지 초기화
$uploadMessage = "";
$uploadMessageType = "";

// upload_secure.php에서 전달한 업로드 결과 확인
// URL의 ?upload=success 또는 ?upload=fail 값에 따라 알림 메시지를 설정
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
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>파일 업로드</title>

    <!-- 공통 CSS / JavaScript -->
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>

<body>

<header>
    <a href="index.php" class="logo-link">
        <h1>🛡 WebShell Defense</h1>
    </a>

    <nav>
        <a href="index.php">HOME</a>

        <!-- 현재 로그인한 사용자 이름 출력 -->
        <span>
            👤 <?= htmlspecialchars(
                $_SESSION["username"],
                ENT_QUOTES,
                "UTF-8"
            ) ?>님
        </span>

        <a href="upload.php">UPLOAD</a>

        <!-- 관리자 계정일 경우에만 ADMIN 메뉴 표시 -->
        <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
            <a href="admin.php">ADMIN</a>
        <?php endif; ?>

        <a href="auth/logout_process.php">LOGOUT</a>
    </nav>
</header>

<main class="upload-container">

    <h1 class="upload-title">📂 파일 업로드</h1>

    <!-- 업로드 성공 또는 실패 결과가 있을 경우 알림 표시 -->
    <?php if ($uploadMessage !== ""): ?>

        <div
            id="uploadAlert"
            class="upload-alert <?= htmlspecialchars(
                $uploadMessageType,
                ENT_QUOTES,
                "UTF-8"
            ) ?>"
            role="alert"
        >
            <!-- 업로드 결과 메시지 출력 -->
            <span>
                <?= htmlspecialchars(
                    $uploadMessage,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </span>

            <!-- 알림 메시지를 닫는 버튼 -->
            <button
                type="button"
                class="upload-alert-close"
                aria-label="알림 닫기"
            >
                &times;
            </button>
        </div>

    <?php endif; ?>

    <!-- 파일 업로드 폼
         multipart/form-data는 파일 데이터를 서버로 전송하기 위해 필요 -->
    <form
        id="uploadForm"
        class="upload-form"
        action="upload/upload_secure.php"
        method="POST"
        enctype="multipart/form-data"
    >
        <!-- 사용자가 업로드할 파일 선택 -->
        <input
            type="file"
            id="file"
            name="file"
            accept="image/jpeg,image/png,image/gif"
            required
        >

        <!-- 선택한 파일을 서버로 전송 -->
        <button
            type="submit"
            class="upload-btn"
        >
            업로드
        </button>
    </form>

    <h2 class="table-title">📋 업로드된 파일 목록</h2>

    <!-- file_list.php의 결과를 현재 페이지 안에 표시 -->
    <iframe
        id="fileListFrame"
        class="file-list-frame"
        src="upload/file_list.php"
        title="업로드된 파일 목록"
    ></iframe>

</main>

<footer>
    <p>
        2026 Summer Sprint Camp
        <br>
        WebShell Defense Project
    </p>
</footer>

</body>

</html>
