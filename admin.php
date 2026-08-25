<?php

// 세션 시작
// 로그인한 사용자의 ID, 이름, 권한 정보를 사용하기 위해 필요
session_start();

// 데이터베이스 연결
require_once "config/db.php";

// 관리자 권한 확인
// 로그인하지 않았거나 관리자가 아니면 로그인 페이지로 이동
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

// 사용자 목록 조회
// 가입된 사용자를 ID 순서대로 가져옴
$sql = "SELECT id, username, role
        FROM users
        ORDER BY id ASC";

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>관리자 페이지</title>

    <!-- 공통 CSS / JavaScript -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<!-- 헤더 -->
<header>
    <a href="index.php" class="logo-link">
        <h1>🛡 WebShell Defense</h1>
    </a>

    <nav>
        <a href="index.php">HOME</a>

        <!-- 현재 로그인한 사용자 이름 출력 -->
        <span>
            👤 <?= htmlspecialchars($_SESSION['username']) ?>님
        </span>

        <a href="upload.php">UPLOAD</a>
        <a href="admin.php">ADMIN</a>
        <a href="auth/logout_process.php">LOGOUT</a>
    </nav>
</header>


<!-- 관리자 페이지 -->
<main class="admin-container">

    <!-- 관리자 페이지 소개 -->
    <section class="admin-intro">
        <h2>👨‍💼 관리자 페이지</h2>
        <p>사용자 계정과 업로드된 파일을 관리할 수 있습니다.</p>
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

                    <!-- DB에서 조회한 사용자를 한 명씩 출력 -->
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>

                        <tr>
                            <!-- 사용자 ID -->
                            <td><?= (int)$row['id'] ?></td>

                            <!-- 사용자 이름 -->
                            <td>
                                <?= htmlspecialchars($row['username']) ?>
                            </td>

                            <!-- 사용자 권한 -->
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
                                // 현재 로그인한 사용자와
                                // 목록에 표시된 사용자가 같은 계정인지 확인
                                $isCurrentUser =
                                    (int)$row['id'] === (int)$_SESSION['user_id'];
                                ?>

                                <?php if ($isCurrentUser): ?>

                                    <!-- 현재 로그인한 관리자 본인은 삭제할 수 없음 -->
                                    <span class="current-user">
                                        현재 계정
                                    </span>

                                <?php else: ?>

                                    <!-- 다른 사용자 삭제 -->
                                    <form
                                        method="POST"
                                        action="auth/admin_action.php"
                                        class="admin-action-form"
                                        onsubmit="return confirm('정말 이 사용자를 삭제하시겠습니까?');"
                                    >
                                        <!-- 삭제할 사용자의 ID를 POST로 전달 -->
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


        <!-- 관리자 파일 업로드 -->
        <section class="admin-card">

            <div class="admin-card-header">
                <div>
                    <h2>📤 파일 업로드</h2>
                    <p>관리자 권한으로 실습 파일을 업로드합니다.</p>
                </div>
            </div>

            <!-- 선택한 파일을 보안 업로드 처리기로 전송 -->
            <form
                id="uploadForm"
                class="admin-upload-form"
                action="upload/upload_secure.php"
                method="POST"
                enctype="multipart/form-data"
            >
                <input
                    type="file"
                    name="file"
                    accept="image/jpeg,image/png,image/gif"
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
                    <p>서버에 업로드된 파일 목록을 확인합니다.</p>
                </div>
            </div>

            <div class="admin-file-list">

                <!-- file_list.php를 관리자 페이지 안에 표시 -->
                <iframe
                    id="adminFileListFrame"
                    class="file-list-frame"
                    src="upload/file_list.php"
                    title="업로드된 파일 목록"
                ></iframe>

            </div>

        </section>

    </div>

</main>


<!-- 푸터 -->
<footer>
    <p>
        2026 Summer Sprint Camp
        <br>
        WebShell Defense Project
    </p>
</footer>

</body>

</html>
