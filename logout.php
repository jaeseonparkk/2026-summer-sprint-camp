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

    <h1>🛡 WebShell Defense</h1>

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

    <form action="auth/logout_process.php" method="POST">
        <button type="submit">
            로그아웃
        </button>
    </form>

    <br>

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