<?php
// 세션을 시작하여 로그인 여부와 관리자 권한을 확인합니다.
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebShell Defense Training</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>

<!-- 로고를 클릭하면 메인 페이지로 이동합니다. -->
<a href="index.php" class="logo-link">
    <h1>🛡 WebShell Defense</h1>
</a>
    <nav>
        <a href="index.php">HOME</a>

        <!-- 로그인한 사용자에게 사용자 이름과 전용 메뉴를 표시합니다. -->
        <?php if(isset($_SESSION['user_id'])): ?>

            <span>
                <!-- 사용자 이름을 이스케이프하여 XSS 위험을 줄입니다. -->
                👤 <?php echo htmlspecialchars($_SESSION['username']); ?>님
            </span>

            <!-- upload.php에서도 별도로 로그인 여부를 검사해야 합니다. -->
            <a href="upload.php">UPLOAD</a>

            <?php if($_SESSION['role'] == 'admin'): ?>
                <!-- admin.php에서도 별도로 관리자 권한을 검사해야 합니다. -->
                <a href="admin.php">ADMIN</a>
            <?php endif; ?>

            <a href="auth/logout_process.php">LOGOUT</a>

        <?php else: ?>

            <!-- 로그인하지 않은 사용자에게 로그인과 회원가입 메뉴를 표시합니다. -->
            <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>

        <?php endif; ?>
    </nav>

</header>

<div class="container">

    <!-- 웹사이트 소개 -->
    <section class="intro">

        <h2>웹쉘 공격 분석을 통한 시큐어 코딩 방어 웹사이트</h2>

        <p>
            본 웹사이트는 웹쉘(WebShell) 공격의 원리를 이해하고,
            취약한 파일 업로드 기능과 시큐어 코딩이 적용된 기능을
            비교·분석하기 위한 교육용 프로젝트입니다.
        </p>

    </section>

    <div class="card-container">

        <div class="card">

            <h3>📂 취약한 파일 업로드</h3>

            <p>
                취약한 업로드 기능을 이용하여
                웹쉘 공격이 가능한 이유를 확인합니다.
            </p>

            <!-- 취약한 파일 업로드 실습 페이지로 이동합니다. -->
            <button onclick="location.href='upload.php'">
                실습하기
            </button>

        </div>

        <div class="card">

            <h3>🔐 시큐어 코딩</h3>

            <p>
                보안 기능이 적용된 업로드 방식을 통해
                공격을 차단하는 방법을 학습합니다.
            </p>

            <!-- 시큐어 코딩 페이지로 이동합니다. -->
            <button onclick="location.href='secure_coding.php'">
                확인하기
            </button>

        </div>

        <div class="card">

            <h3>👨‍💼 관리자</h3>

            <p>
                관리자 페이지에서
                업로드 결과와 파일을 관리합니다.
            </p>

            <!-- 실제 접근 권한은 admin.php에서 별도로 검사합니다. -->
            <button onclick="location.href='admin.php'">
                관리자
            </button>

        </div>

    </div>

</div>

<footer>

    <p>
        2026 Summer Sprint Camp
        <br>
        WebShell Defense Project
    </p>

</footer>

</body>
</html>
