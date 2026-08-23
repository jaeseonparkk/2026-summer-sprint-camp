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

    <h2>회원가입</h2>

    <!-- 회원가입 정보를 POST 방식으로 register_process.php에 전달
         실제 입력값 검사, 비밀번호 해시 및 DB 저장은 register_process.php에서 처리 -->
    <form action="auth/register_process.php" method="POST">

        <!-- 사용자 아이디 입력 -->
        <input 
            type="text"
            name="username"
            placeholder="아이디"
            required>
        <!-- 비밀번호 입력 시 글자가 보이지 않도록 표시
             실제 비밀번호 해시는 register_process.php에서 처리 -->
        <input
            type="password"
            name="password"
            placeholder="비밀번호"
            required>
        <!-- 사용자 이름 입력 -->
        <input
            type="text"
            name="name"
            placeholder="이름"
            required>
        <!-- 입력한 회원가입 정보를 Form으로 제출 -->
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
