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

    <h1>🛡 WebShell Defense</h1>

    <nav>
        <a href="index.php">HOME</a>
        <a href="login.php">LOGIN</a>
        <a href="register.php">REGISTER</a>
        <a href="upload.php">UPLOAD</a>
        <a href="admin.php">ADMIN</a>
    </nav>

</header>

<div class="container">

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

            <button onclick="location.href='upload.php'">
                확인하기
            </button>

        </div>

        <div class="card">

            <h3>👨‍💼 관리자</h3>

            <p>
                관리자 페이지에서
                업로드 결과와 파일을 관리합니다.
            </p>

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