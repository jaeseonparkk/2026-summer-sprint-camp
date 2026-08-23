<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그아웃</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>

<a href="index.php" class="logo-link">
    <h1>🛡 WebShell Defense</h1>
</a>

    <nav>
        <a href="index.php">HOME</a>
        <a href="login.php">LOGIN</a>
        <a href="register.php">REGISTER</a>
    </nav>

</header>

<div class="form-box">

    <h2>로그아웃</h2>

    <p>정말 로그아웃하시겠습니까?</p>

    <br>

    <!-- 로그아웃 요청을 POST 방식으로 전달합니다. -->
    <form action="auth/logout_process.php" method="POST">
        <!-- 실제 세션 삭제는 logout_process.php에서 처리합니다. -->
        <button type="submit">
            로그아웃
        </button>
    </form>

    <br>

    <!-- 로그아웃하지 않고 메인 페이지로 이동합니다. -->
    <button onclick="location.href='index.php'">
        메인으로
    </button>

</div>

<footer>

    <p>
        2026 Summer Sprint Camp<br>
        WebShell Defense Project
    </p>

</footer>

</body>

</html>
