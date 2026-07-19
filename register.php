<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>

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

    <h2>회원가입</h2>

    <form action="auth/register_process.php" method="POST">

        <input
            type="text"
            name="username"
            placeholder="아이디"
            required>

        <input
            type="password"
            name="password"
            placeholder="비밀번호"
            required>

        <input
            type="text"
            name="name"
            placeholder="이름"
            required>

        <button type="submit">
            회원가입
        </button>

    </form>

    <p>
        이미 계정이 있으신가요?
        <a href="login.php">로그인</a>
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