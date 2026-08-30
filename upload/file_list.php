<?php
declare(strict_types=1);

// 로그인 사용자 정보와 권한 확인에 사용
session_start();

// 데이터베이스 연결
require_once __DIR__ . "/../config/db.php";

// 로그인 여부 확인
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("로그인이 필요합니다.");
}

// 현재 로그인한 사용자 정보
$userId = (int) $_SESSION["user_id"];
$isAdmin = ($_SESSION["role"] ?? "") === "admin";

// 관리자와 일반 사용자의 파일 조회 범위를 구분
if ($isAdmin) {

    // 관리자: 모든 사용자의 업로드 파일 조회
    // users 테이블과 JOIN하여 업로드한 사용자 이름도 함께 가져옴
    $statement = $pdo->query(
        "SELECT f.id, u.username, f.file_name, f.file_type, f.upload_time
         FROM uploaded_files AS f
         INNER JOIN users AS u ON u.id = f.user_id
         ORDER BY f.id DESC"
    );

} else {

    // 일반 사용자: 현재 로그인한 사용자가 업로드한 파일만 조회
    $statement = $pdo->prepare(
        "SELECT id, file_name, file_type, upload_time
         FROM uploaded_files
         WHERE user_id = ?
         ORDER BY id DESC"
    );
    $statement->execute([$userId]);
}

// 조회한 파일 목록을 배열 형태로 저장
$files = $statement->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<table class="upload-table">
    <thead>
    <tr>
        <th>번호</th>
        <!-- 관리자에게만 업로드 사용자 표시 -->
        <?php if ($isAdmin): ?><th>사용자</th><?php endif; ?>
        <th>파일명</th>
        <th>파일 형식</th>
        <th>업로드 시간</th>
        <th>관리</th>
    </tr>
    </thead>
    <tbody>
    <!-- 업로드된 파일이 없는 경우 -->
    <?php if ($files === []): ?>
        <tr><td colspan="<?= $isAdmin ? 6 : 5 ?>" class="empty">등록된 파일이 없습니다.</td></tr>
    <?php else: ?>
        <!-- 조회한 파일 목록 출력 -->
        <?php foreach ($files as $file): ?>
            <tr>
                <td><?= (int) $file["id"] ?></td>
                <!-- 관리자인 경우 업로드한 사용자 이름 출력 -->
                <?php if ($isAdmin): ?>
                    <td><?= htmlspecialchars($file["username"], ENT_QUOTES, "UTF-8") ?></td>
                <?php endif; ?>
                <td>
                    <!-- 파일명을 URL에 넣기 때문에 rawurlencode() 사용 화면 출력 시
                     htmlspecialchars()를 적용하여 XSS 위험 방지 -->
                    <a href="../uploads/<?= rawurlencode($file["file_name"]) ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?= htmlspecialchars($file["file_name"], ENT_QUOTES, "UTF-8") ?>
                    </a>
                </td>
                <!-- 출력값을 HTML 특수문자로 변환하여 XSS 위험 방지 -->
                <td><?= htmlspecialchars($file["file_type"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($file["upload_time"], ENT_QUOTES, "UTF-8") ?></td>
                <td>
                    <!-- 삭제할 파일 ID를 POST 방식으로 delete_file.php에 전달 -->
                    <form method="POST" action="delete_file.php">
                        <input type="hidden" name="file_id" value="<?= (int) $file["id"] ?>">
                        <button type="submit" class="delete-btn">삭제</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>
