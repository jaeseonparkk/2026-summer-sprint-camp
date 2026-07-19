<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>

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

    <h2>로그인</h2>

    <form action="auth/login_process.php" method="POST">

        <input
            type="text"
            name="id"
            placeholder="아이디"
            required>

        <input
            type="password"
            name="password"
            placeholder="비밀번호"
            required>

        <button type="submit">
            로그인
        </button>

    </form>

    <p>
        아직 회원이 아니신가요?
        <a href="register.php">회원가입</a>
    </p>

</div>

<footer>

    <p>
        2026 Summer Sprint Camp<br>
        WebShell Defense Project
    </p>

</footer>

</body>

</html>