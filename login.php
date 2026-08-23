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

<a href="index.php" class="logo-link"> /*웹사이트의 로고와 이름을 클릭하면 index.php로 이동함 */
    <h1>🛡 WebShell Defense</h1>
</a>

    <nav> /* 이후 각 페이지로 이동 */
        <a href="index.php">HOME</a>
        <a href="login.php">LOGIN</a>
        <a href="register.php">REGISTER</a>
    </nav>

</header>

<div class="form-box">

    <h2>로그인</h2>

    <!-- 사용자가 로그인 버튼을 누르면 입력한 데이터를 auth/login_process.php로 전송
         실제 인증 및 DB 조회는 login_process.php에서 처리
         method="POST"를 사용하여 아이디와 비밀번호를 HTTP POST 방식으로 전달 -->
    <form action="auth/login_process.php" method="POST">

        <input
            type="text"
            name="username"
            placeholder="아이디"
            required>
        <!-- required: 값을 입력하지 않으면 브라우저에서 폼 제출을 막음 -->

        <input
            type="password"
            name="password"
            placeholder="비밀번호"
            required>
        <!-- type="password": 입력한 글자가 보이지 않도록 표시
             비밀번호 자체를 암호화하는 기능은 아님 -->

        <!-- submit 버튼을 누르면 form에 입력된 데이터가 제출됨 -->
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