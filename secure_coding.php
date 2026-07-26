<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Secure Coding Wiki</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header>

    <a href="index.php" class="logo-link">
        <h1>🛡 WebShell Defense</h1>
    </a>

    <nav>
        <a href="index.php">HOME</a>

        <?php if (isset($_SESSION['user_id'])): ?>

            <span>
                👤 <?php echo htmlspecialchars($_SESSION['username']); ?>님
            </span>

            <a href="upload.php">UPLOAD</a>

            <a href="secure_coding.php">SECURE CODING</a>

            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                <a href="admin.php">ADMIN</a>
            <?php endif; ?>

            <a href="auth/logout_process.php">LOGOUT</a>

        <?php else: ?>

            <a href="login.php">LOGIN</a>
            <a href="register.php">REGISTER</a>

        <?php endif; ?>
    </nav>

</header>


<main class="wiki-page">

    <!-- 페이지 소개 -->
    <section class="wiki-hero">

        <h2>🔐 Secure Coding Wiki</h2>

        <p>
            SQL Injection과 File Upload 취약점의 공격 원리를 이해하고,
            안전한 코딩 기법을 적용하여 공격을 방어하는 과정을 설명합니다.
        </p>

    </section>


    <!-- 목차 -->
    <section class="wiki-card wiki-toc">

        <div class="wiki-section-header">
            <h2>📑 목차</h2>
            <p>각 항목을 선택하면 해당 설명으로 이동합니다.</p>
        </div>

        <div class="wiki-toc-grid">

            <a href="#intro">
                <span>01</span>
                프로젝트 소개
            </a>

            <a href="#scenario">
                <span>02</span>
                공격 시나리오
            </a>

            <a href="#sqli">
                <span>03</span>
                SQL Injection
            </a>

            <a href="#upload">
                <span>04</span>
                File Upload
            </a>

            <a href="#webshell">
                <span>05</span>
                Web Shell
            </a>

            <a href="#secure">
                <span>06</span>
                Secure Coding
            </a>

            <a href="#compare">
                <span>07</span>
                공격 전·후 비교
            </a>

        </div>

    </section>


    <!-- 1. 프로젝트 소개 -->
    <section id="intro" class="wiki-card">

        <div class="wiki-section-header">
            <h2>1. 프로젝트 소개</h2>

            <p>
                취약한 웹 애플리케이션과 보안이 적용된 웹 애플리케이션을
                직접 비교하는 교육용 프로젝트입니다.
            </p>
        </div>

        <div class="wiki-content">

            <p>
                본 프로젝트는 웹 애플리케이션에서 자주 발생하는
                <strong>SQL Injection</strong>과
                <strong>File Upload 취약점</strong>을 학습하기 위해 제작되었습니다.
            </p>

            <p>
                사용자는 취약한 기능이 공격에 어떻게 악용되는지 확인하고,
                Secure Coding을 적용했을 때 동일한 공격이 차단되는 과정을
                직접 비교할 수 있습니다.
            </p>

            <div class="project-info">

                <article class="info-card">
                    <h3>🎯 프로젝트 목표</h3>

                    <p>
                        취약점의 발생 원인을 이해하고,
                        보안 코드 적용 전후의 차이를 학습합니다.
                    </p>
                </article>

                <article class="info-card">
                    <h3>🛠 사용 기술</h3>

                    <ul>
                        <li>PHP</li>
                        <li>MariaDB</li>
                        <li>Docker</li>
                        <li>HTML / CSS / JavaScript</li>
                    </ul>
                </article>

                <article class="info-card">
                    <h3>📚 학습 내용</h3>

                    <ul>
                        <li>SQL Injection 원리</li>
                        <li>파일 업로드 검증</li>
                        <li>웹쉘 공격 과정</li>
                        <li>Secure Coding 적용</li>
                    </ul>
                </article>

            </div>

        </div>

    </section>


    <!-- 2. 공격 시나리오 -->
    <section id="scenario" class="wiki-card">

        <div class="wiki-section-header">
            <h2>2. 공격 시나리오</h2>

            <p>
                취약한 파일 업로드 기능이 웹쉘 공격으로 이어지는 과정을 설명합니다.
            </p>
        </div>

        <div class="scenario-flow">

            <article class="scenario-step">
                <span class="step-number">1</span>

                <div>
                    <h3>취약한 업로드 기능 확인</h3>

                    <p>
                        서버가 파일의 확장자와 실제 파일 형식을 충분히 검사하지 않는지 확인합니다.
                    </p>
                </div>
            </article>

            <div class="scenario-arrow">↓</div>

            <article class="scenario-step">
                <span class="step-number">2</span>

                <div>
                    <h3>악성 스크립트 업로드 시도</h3>

                    <p>
                        공격자는 서버에서 실행할 수 있는 스크립트 파일의 업로드를 시도합니다.
                    </p>
                </div>
            </article>

            <div class="scenario-arrow">↓</div>

            <article class="scenario-step">
                <span class="step-number">3</span>

                <div>
                    <h3>업로드 파일 경로 접근</h3>

                    <p>
                        업로드된 파일이 공개된 웹 경로에 저장되면 브라우저에서 직접 접근할 수 있습니다.
                    </p>
                </div>
            </article>

            <div class="scenario-arrow">↓</div>

            <article class="scenario-step danger-step">
                <span class="step-number">4</span>

                <div>
                    <h3>웹쉘 실행 위험</h3>

                    <p>
                        서버가 업로드 파일을 PHP 코드로 실행하면
                        공격자가 서버 명령을 실행할 가능성이 생깁니다.
                    </p>
                </div>
            </article>

        </div>

        <div class="wiki-warning">

            <strong>⚠ 주의</strong>

            <p>
                본 실습은 교육 목적으로 구성된 로컬 Docker 환경에서만 진행해야 합니다.
                허가받지 않은 서버를 대상으로 공격을 시도해서는 안 됩니다.
            </p>

        </div>

    </section>


    <!-- 3. SQL Injection -->
    <section id="sqli" class="wiki-card">

        <div class="wiki-section-header">
            <h2>3. SQL Injection</h2>

            <p>
                사용자 입력값이 SQL 명령문에 직접 포함될 때 발생하는 취약점입니다.
            </p>
        </div>

        <div class="wiki-content">

            <h3>취약점 발생 원인</h3>

            <p>
                로그인 폼에서 전달된 아이디와 비밀번호를 검증하지 않고
                SQL 문자열에 직접 연결하면 입력값이 SQL 문법으로 해석될 수 있습니다.
            </p>

            <div class="code-example code-danger">

                <div class="code-title">
                    <span>❌ 취약한 SQL 처리</span>
                    <span class="danger-label">Vulnerable</span>
                </div>

                <pre><code>$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users
        WHERE username = '$username'
        AND password = '$password'";

$result = mysqli_query($conn, $sql);</code></pre>

            </div>

            <p>
                위 코드는 사용자 입력이 SQL 문자열 내부에 그대로 들어가기 때문에
                공격자가 SQL 문법을 조작할 가능성이 있습니다.
            </p>

            <h3>방어 방법</h3>

            <div class="security-list">

                <div>
                    <strong>Prepared Statement 사용</strong>
                    <p>SQL 구조와 사용자 입력값을 분리합니다.</p>
                </div>

                <div>
                    <strong>입력값 검증</strong>
                    <p>허용할 문자와 길이를 제한합니다.</p>
                </div>

                <div>
                    <strong>비밀번호 해시 사용</strong>
                    <p>비밀번호를 평문으로 저장하거나 직접 비교하지 않습니다.</p>
                </div>

                <div>
                    <strong>오류 메시지 제한</strong>
                    <p>데이터베이스 구조가 노출되지 않도록 처리합니다.</p>
                </div>

            </div>

            <div class="code-example code-safe">

                <div class="code-title">
                    <span>✅ Prepared Statement 적용</span>
                    <span class="safe-label">Secure</span>
                </div>

                <pre><code>$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare(
    "SELECT id, username, password, role
     FROM users
     WHERE username = ?"
);

$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    // 로그인 성공
}</code></pre>

            </div>

        </div>

    </section>


    <!-- 4. File Upload -->
    <section id="upload" class="wiki-card">

        <div class="wiki-section-header">
            <h2>4. File Upload 취약점</h2>

            <p>
                검증되지 않은 파일을 서버에 저장할 때 발생하는 보안 문제입니다.
            </p>
        </div>

        <div class="wiki-content">

            <h3>취약한 업로드 기능의 특징</h3>

            <div class="security-list">

                <div>
                    <strong>확장자 검사 없음</strong>
                    <p>PHP, HTML 등의 실행 가능한 파일을 업로드할 수 있습니다.</p>
                </div>

                <div>
                    <strong>MIME 타입 검사 없음</strong>
                    <p>파일 이름만 변경한 위장 파일을 구분하지 못합니다.</p>
                </div>

                <div>
                    <strong>원본 파일명 사용</strong>
                    <p>동일한 파일명 충돌과 경로 조작 위험이 발생할 수 있습니다.</p>
                </div>

                <div>
                    <strong>웹 경로에 직접 저장</strong>
                    <p>업로드된 파일이 브라우저에서 바로 실행될 수 있습니다.</p>
                </div>

            </div>

            <div class="code-example code-danger">

                <div class="code-title">
                    <span>❌ 검증이 없는 파일 업로드</span>
                    <span class="danger-label">Vulnerable</span>
                </div>

                <pre><code>$fileName = $_FILES['upload_file']['name'];
$tmpName = $_FILES['upload_file']['tmp_name'];

move_uploaded_file(
    $tmpName,
    "uploads/" . $fileName
);</code></pre>

            </div>

            <p>
                위 코드에서는 파일 형식, 크기, 이름을 검사하지 않고
                원본 파일명 그대로 공개 디렉터리에 저장합니다.
            </p>

        </div>

    </section>


    <!-- 5. Web Shell -->
    <section id="webshell" class="wiki-card">

        <div class="wiki-section-header">
            <h2>5. Web Shell</h2>

            <p>
                웹 서버에 업로드되어 서버 기능을 원격으로 조작할 수 있게 하는 악성 스크립트입니다.
            </p>
        </div>

        <div class="wiki-content">

            <p>
                웹쉘은 웹 서버가 실행할 수 있는 PHP, JSP 등의 스크립트 형태로 제작됩니다.
                공격자는 취약한 파일 업로드 기능을 통해 웹쉘을 서버에 저장한 후,
                해당 파일에 접근하여 서버를 조작하려고 시도합니다.
            </p>

            <div class="webshell-grid">

                <article>
                    <h3>📂 파일 접근</h3>
                    <p>서버에 저장된 파일과 디렉터리를 조회할 수 있습니다.</p>
                </article>

                <article>
                    <h3>🖥 명령 실행</h3>
                    <p>서버 운영체제 명령 실행으로 이어질 수 있습니다.</p>
                </article>

                <article>
                    <h3>🗄 정보 탈취</h3>
                    <p>환경 설정과 데이터베이스 정보가 노출될 수 있습니다.</p>
                </article>

                <article>
                    <h3>🔁 추가 공격</h3>
                    <p>다른 시스템을 공격하기 위한 경유지로 악용될 수 있습니다.</p>
                </article>

            </div>

            <div class="wiki-warning">

                <strong>🚨 주요 위험</strong>

                <p>
                    단순히 파일 하나가 업로드되는 문제로 끝나는 것이 아니라,
                    서버 전체 권한 침해로 이어질 수 있습니다.
                </p>

            </div>

        </div>

    </section>


    <!-- 6. Secure Coding -->
    <section id="secure" class="wiki-card">

        <div class="wiki-section-header">
            <h2>6. Secure Coding 적용</h2>

            <p>
                확장자, MIME 타입, 파일 크기와 저장 경로를 모두 검증해야 합니다.
            </p>
        </div>

        <div class="wiki-content">

            <div class="secure-checklist">

                <label>
                    <span>✓</span>
                    업로드 오류 코드 확인
                </label>

                <label>
                    <span>✓</span>
                    파일 크기 제한
                </label>

                <label>
                    <span>✓</span>
                    허용 확장자 목록 사용
                </label>

                <label>
                    <span>✓</span>
                    실제 MIME 타입 검사
                </label>

                <label>
                    <span>✓</span>
                    서버에서 파일명 재생성
                </label>

                <label>
                    <span>✓</span>
                    실행 불가능한 경로에 저장
                </label>

            </div>

            <div class="code-example code-safe">

                <div class="code-title">
                    <span>✅ 안전한 파일 업로드 예시</span>
                    <span class="safe-label">Secure</span>
                </div>

                <pre><code>&lt;?php

$uploadDir = __DIR__ . "/uploads/";
$maxFileSize = 5 * 1024 * 1024;

$allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

$allowedMimeTypes = [
    'image/jpeg',
    'image/png',
    'application/pdf'
];

if (
    !isset($_FILES['upload_file']) ||
    $_FILES['upload_file']['error'] !== UPLOAD_ERR_OK
) {
    exit('파일 업로드에 실패했습니다.');
}

$file = $_FILES['upload_file'];

if ($file['size'] > $maxFileSize) {
    exit('파일 크기는 5MB를 초과할 수 없습니다.');
}

$originalName = basename($file['name']);

$extension = strtolower(
    pathinfo($originalName, PATHINFO_EXTENSION)
);

if (!in_array($extension, $allowedExtensions, true)) {
    exit('허용되지 않은 확장자입니다.');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($file['tmp_name']);

if (!in_array($mimeType, $allowedMimeTypes, true)) {
    exit('허용되지 않은 파일 형식입니다.');
}

$safeFileName = bin2hex(random_bytes(16))
              . '.'
              . $extension;

$destination = $uploadDir . $safeFileName;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    exit('파일 저장에 실패했습니다.');
}

echo '파일이 안전하게 업로드되었습니다.';</code></pre>

            </div>

            <div class="wiki-note">

                <strong>💡 핵심</strong>

                <p>
                    클라이언트가 전송한 파일명과 MIME 타입을 그대로 신뢰하면 안 됩니다.
                    서버에서 직접 파일 형식을 검사하고 새로운 파일명을 생성해야 합니다.
                </p>

            </div>

        </div>

    </section>


    <!-- 7. 공격 전후 비교 -->
    <section id="compare" class="wiki-card">

        <div class="wiki-section-header">
            <h2>7. 공격 전·후 비교</h2>

            <p>
                Secure Coding 적용 전과 적용 후의 차이를 비교합니다.
            </p>
        </div>

        <div class="compare-table-wrapper">

            <table class="compare-table">

                <thead>
                <tr>
                    <th>비교 항목</th>
                    <th class="vulnerable-column">취약한 코드</th>
                    <th class="secure-column">Secure Coding</th>
                </tr>
                </thead>

                <tbody>

                <tr>
                    <td>파일 확장자</td>
                    <td>모든 확장자 허용</td>
                    <td>허용 목록만 통과</td>
                </tr>

                <tr>
                    <td>MIME 타입</td>
                    <td>검사하지 않음</td>
                    <td>서버에서 실제 형식 검사</td>
                </tr>

                <tr>
                    <td>파일명</td>
                    <td>원본 파일명 사용</td>
                    <td>무작위 파일명 생성</td>
                </tr>

                <tr>
                    <td>파일 크기</td>
                    <td>제한 없음</td>
                    <td>최대 크기 제한</td>
                </tr>

                <tr>
                    <td>저장 경로</td>
                    <td>웹에서 직접 접근 가능</td>
                    <td>실행 권한이 제한된 경로</td>
                </tr>

                <tr>
                    <td>웹쉘 업로드</td>
                    <td>
                        <span class="compare-danger">업로드 가능</span>
                    </td>
                    <td>
                        <span class="compare-safe">업로드 차단</span>
                    </td>
                </tr>

                </tbody>

            </table>

        </div>

    </section>


    <!-- 학습 결과 -->
    <section class="wiki-result">

        <h2>✅ 학습 결과</h2>

        <p>
            파일 업로드 기능에서는 단순한 확장자 확인만으로 충분하지 않습니다.
            확장자, MIME 타입, 크기, 파일명, 저장 경로를 함께 검증해야
            웹쉘 업로드와 서버 침해를 효과적으로 방어할 수 있습니다.
        </p>

        <div class="wiki-result-buttons">

            <button type="button" onclick="location.href='upload.php'">
                취약한 업로드 실습
            </button>

            <button
                type="button"
                class="secondary-button"
                onclick="location.href='index.php'"
            >
                메인으로 이동
            </button>

        </div>

    </section>

</main>


<footer>

    <p>
        2026 Summer Sprint Camp
        <br>
        WebShell Defense Project
    </p>

</footer>

</body>

</html>