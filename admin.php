<?php
session_start();
require_once "config/db.php";

// 관리자 권한 확인
if (
    !isset($_SESSION['user_id']) ||
    ($_SESSION['role'] ?? '') !== 'admin'
) {
    header("Location: login.php");
    exit;
}

// 사용자 목록 조회
$sql = "SELECT id, username, role
        FROM users
        ORDER BY id ASC";

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>관리자 페이지</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

    <script
        src="js/script.js"
        defer
    ></script>
</head>

<body>

<header>
    <a href="index.php" class="logo-link">
        <h1>🛡 WebShell Defense</h1>
    </a>

    <nav>
        <a href="index.php">HOME</a>

        <span>
            👤 <?= htmlspecialchars($_SESSION['username']) ?>님
        </span>

        <a href="upload.php">UPLOAD</a>
        <a href="admin.php">ADMIN</a>
        <a href="auth/logout_process.php">LOGOUT</a>
    </nav>
</header>

<main class="admin-container">

    <section class="admin-intro">
        <h2>👨‍💼 관리자 페이지</h2>

        <p>
            사용자 계정과 업로드된 파일을 관리할 수 있습니다.
        </p>
    </section>

    <div class="admin-grid">

        <!-- 사용자 관리 -->
        <section class="admin-card admin-user-card">

            <div class="admin-card-header">
                <div>
                    <h2>👥 사용자 관리</h2>
                    <p>가입된 사용자와 권한을 확인합니다.</p>
                </div>
            </div>

            <div class="table-wrapper">

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>

                        <tr>
                            <td>
                                <?= (int)$row['id'] ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($row['username']) ?>
                            </td>

                            <td>
                                <?php if ($row['role'] === 'admin'): ?>

                                    <span class="role-badge admin-role">
                                        ADMIN
                                    </span>

                                <?php else: ?>

                                    <span class="role-badge user-role">
                                        USER
                                    </span>

                                <?php endif; ?>
                            </td>

                            <td>
                                <?php
                                $isCurrentUser =
                                    (int)$row['id'] ===
                                    (int)$_SESSION['user_id'];
                                ?>

                                <?php if ($isCurrentUser): ?>

                                    <span class="current-user">
                                        현재 계정
                                    </span>

                                <?php else: ?>

                                    <form
                                        method="POST"
                                        action="auth/admin_action.php"
                                        class="admin-action-form"
                                        onsubmit="return confirm('정말 이 사용자를 삭제하시겠습니까?');"
                                    >
                                        <input
                                            type="hidden"
                                            name="user_id"
                                            value="<?= (int)$row['id'] ?>"
                                        >

                                        <button
                                            type="submit"
                                            class="admin-delete-btn"
                                        >
                                            삭제
                                        </button>
                                    </form>

                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                    </tbody>
                </table>

            </div>
        </section>

        <!-- 파일 업로드 -->
        <section class="admin-card">

            <div class="admin-card-header">
                <div>
                    <h2>📤 파일 업로드</h2>

                    <p>
                        관리자 권한으로 실습 파일을 업로드합니다.
                    </p>
                </div>
            </div>

            <form
                id="uploadForm"
                class="admin-upload-form"
                action="upload/upload_vulnerable.php"
                method="POST"
                enctype="multipart/form-data"
            >
                <input
                    type="file"
                    name="file"
                    required
                >

                <button type="submit">
                    업로드
                </button>
            </form>

        </section>

        <!-- 업로드된 파일 목록 -->
        <section class="admin-card">

            <div class="admin-card-header">
                <div>
                    <h2>📁 업로드된 파일</h2>

                    <p>
                        서버에 업로드된 파일 목록을 확인합니다.
                    </p>
                </div>
            </div>

            <div class="admin-file-list">
                <ul id="files">
                    <li class="empty">
                        업로드된 파일을 불러오는 중입니다.
                    </li>
                </ul>
            </div>

        </section>

    </div>

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