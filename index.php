<?php
session_start();
?> /*php의 세션을 사용하기 위해 실행하는 코드. 사용자가 로그인했는지, 관리자인지를 판단함 */

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

<a href="index.php" class="logo-link">
    <h1>🛡 WebShell Defense</h1>
</a> /*웹사이트의 로고와 이름을 클릭하면 index.php로 이동함 */ 
    <nav>
        <a href="index.php">HOME</a>

        <?php if(isset($_SESSION['user_id'])): ?> /*사용자가 로그인했는지 확인하는 조건문. 로그인한 경우, 사용자 이름과 업로드, 관리자, 로그아웃 링크를 보여줌 */

            <span>
               👤 <?php echo htmlspecialchars($_SESSION['username']); ?>님 /*사용자 이름에 코드가 들어있어도 문자열로 처리하도록 함.(XSS 위험 줄임) */
            </span>

            <a href="upload.php">UPLOAD</a> /* 로그인한 사람에게만 메뉴 보임 (사용자가 직접 주소창에 upload.php를 입력할 수도 있기 때문에 upload.php에서도 별도로 세션 검사필요) */

            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="admin.php">ADMIN</a> /* 관리자인 경우에만 관리자 메뉴 보임 (사용자가 직접 주소창에 admin.php를 입력할 수도 있기 때문에 admin.php에서도 별도로 세션 검사필요)*/
            <?php endif; ?>

            <a href="auth/logout_process.php">LOGOUT</a>

        <?php else: ?> /* 사용자가 로그인하지 않은 경우, 로그인과 회원가입 링크를 보여줌 */

            <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>

        <?php endif; ?>
    </nav>

</header>

<div class="container">

    <section class="intro"> /*웹사이트의 소개 부분 */

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

            <button onclick="location.href='upload.php'"> /* 클릭하면 upload.php로 이동*/
                실습하기
            </button>

        </div>

        <div class="card">

            <h3>🔐 시큐어 코딩</h3>

            <p>
                보안 기능이 적용된 업로드 방식을 통해
                공격을 차단하는 방법을 학습합니다.
            </p>

            <button onclick="location.href='secure_coding.php'"> /* 클릭하면 secure_coding.php로 이동*/
                확인하기
            </button>

        </div>

        <div class="card">

            <h3>👨‍💼 관리자</h3>

            <p>
                관리자 페이지에서
                업로드 결과와 파일을 관리합니다.
            </p>

            <button onclick="location.href='admin.php'"> /* 관리자 버튼은 모든 사용자에게 표시되지만 실제 관리자 페이지 접근 권한은 admin.php에서 별도로 검사 */
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