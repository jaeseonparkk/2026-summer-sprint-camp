<?php
/*
===========================================
파일명 : config/db.php
역할 : MySQL 데이터베이스 연결
===========================================
*/

// 데이터베이스 정보
$host = "mariadb";
$dbname = "secure_web";
$username = "root";
$password = "73459375298375";

// 문자셋
$charset = "utf8mb4";

// PDO 연결 문자열
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {

    // PDO 객체 생성
    $pdo = new PDO($dsn, $username, $password);

    // SQL 오류 발생 시 예외(Exception) 발생
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 데이터를 연관배열 형태로 가져오기
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {

    // 실제 서비스에서는 상세 오류를 출력하지 않는 것이 안전
    die("DB 연결 실패");
    // 개발 중에는 아래처럼 확인 가능
    // die("DB 연결 실패 : " . $e->getMessage());
}
?>