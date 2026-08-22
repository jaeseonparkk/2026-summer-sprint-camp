<?php

require_once("auth/auth_check.php");

$uploadMessage = "";
$uploadMessageType = "";

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

        <span>
            👤 <?= htmlspecialchars($_SESSION["username"], ENT_QUOTES, "UTF-8") ?>님
        </span>

        <a href="upload.php">UPLOAD</a>

        <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
            <a href="admin.php">ADMIN</a>
        <?php endif; ?>

        <a href="auth/logout_process.php">LOGOUT</a>
    </nav>
</header>

<main class="upload-container">

    <h1 class="upload-title">📂 파일 업로드</h1>

    <?php if ($uploadMessage !== ""): ?>
        <div
            id="uploadAlert"
            class="upload-alert <?= htmlspecialchars($uploadMessageType, ENT_QUOTES, "UTF-8") ?>"
            role="alert"
        >
            <span>
                <?= htmlspecialchars($uploadMessage, ENT_QUOTES, "UTF-8") ?>
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

    <form
        id="uploadForm"
        class="upload-form"
        action="upload/upload_vulnerable.php"
        method="POST"
        enctype="multipart/form-data"
    >
        <input
            type="file"
            id="file"
            name="file"
        >

        <button
            type="submit"
            class="upload-btn"
        >
            업로드
        </button>
    </form>

    <h2 class="table-title">📋 업로드된 파일 목록</h2>

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