<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Secure Coding Wiki</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <div class="wiki-container">

        <h1>Secure Coding Wiki</h1>

        <p class="wiki-subtitle">

            SQL Injection 및 File Upload 취약점을 이용한 공격과
            Secure Coding 적용 과정을 설명하는 프로젝트 문서입니다.

        </p>

        <hr>
        
        <nav class="wiki-toc">
            <h2>📑 목차</h2>
            <ul>
                <li><a href="#intro">1. 프로젝트 소개</a></li>
                <li><a href="#scenario">2. 공격 시나리오</a></li>
                <li><a href="#sqli">3. SQL Injection</a></li>
                <li><a href="#upload">4. File Upload</a></li>
                <li><a href="#webshell">5. Web Shell</a></li>
                <li><a href="#secure">6. Secure Coding</a></li>
                <li><a href="#compare">7. 공격 전·후 비교</a></li>
            </ul>
        </nav>

        <section id="intro">
            <h2>1. 프로젝트 소개</h2>

            <p>

                본 프로젝트는 <strong>웹 애플리케이션의 대표적인 보안 취약점</strong>인
                <strong>SQL Injection</strong>과
                <strong>File Upload 취약점</strong>을 직접 실습하고,
                Secure Coding을 적용하여 동일한 공격을 방어하는 과정을 학습하기 위해 제작되었습니다.

            </p>

            <p>

                사용자는 취약한 웹 서비스를 대상으로 공격을 수행한 후,
                보안 기법을 적용하여 공격이 더 이상 성공하지 않는 과정을 직접 확인할 수 있습니다.

            </p>

            <div class="project-info">

                <div class="info-card">

                    <h3>🎯 프로젝트 목표</h3>

                    <p>
                        취약한 웹 서비스를 직접 공격하고,
                        Secure Coding 적용 전후를 비교하여
                        보안의 중요성을 학습합니다.
                    </p>

                </div>

                <div class="info-card">

                    <h3>🛠 사용 기술</h3>

                    <ul>

                        <li>PHP</li>

                        <li>MariaDB</li>

                        <li>Docker</li>

                        <li>HTML / CSS</li>

                    </ul>

                </div>

                <div class="info-card">

                    <h3>📚 학습 내용</h3>

                    <ul>

                        <li>SQL Injection</li>

                        <li>File Upload</li>

                        <li>Web Shell</li>

                        <li>Secure Coding</li>

                    </ul>

                </div>

            </div>

        </section>
        
        <section id="scenario">
            <h2>2. 공격 시나리오</h2>
        </section>
        
        <section id="sqli">
            <h2>3. SQL Injection</h2>
        </section>

        <section id="upload">
            <h2>4. File Upload</h2>
        </section>
        
        <section id="webshell">
            <h2>5. Web Shell</h2>
        </section>

        <section id="secure">
            <h2>6. Secure Coding</h2>
        </section>
        
        <section id="compare">
            <h2>7. 공격 전·후 비교</h2>
        </section>
    
    </div>

</body>

</html>