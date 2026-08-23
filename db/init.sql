-- 데이터베이스 생성
CREATE DATABASE IF NOT EXISTS secure_web
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- 데이터베이스 선택
USE secure_web;


-- 회원 테이블 생성
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- 업로드 파일 테이블 생성
CREATE TABLE IF NOT EXISTS uploaded_files (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- 사용자가 삭제되면 해당 사용자의 업로드 기록도 함께 삭제
    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);


-- 관리자 계정 생성
-- 비밀번호는 bcrypt 해시값으로 저장
INSERT INTO users (username, password, role)
VALUES (
    'admin',
    '$2y$12$8I6s2fDjfFgWcPPOQTBGvOPFHSFxFWlYkcX8V/xI.BolEomNM8JQG',
    'admin'
)
ON DUPLICATE KEY UPDATE
    password = VALUES(password),
    role = 'admin';