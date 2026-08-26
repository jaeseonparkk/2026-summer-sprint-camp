<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit("로그인이 필요합니다.");
}

$userId = (int) $_SESSION["user_id"];
$isAdmin = ($_SESSION["role"] ?? "") === "admin";

if ($isAdmin) {
    $statement = $pdo->query(
        "SELECT f.id, u.username, f.file_name, f.file_type, f.upload_time
         FROM uploaded_files AS f
         INNER JOIN users AS u ON u.id = f.user_id
         ORDER BY f.id DESC"
    );
} else {
    $statement = $pdo->prepare(
        "SELECT id, file_name, file_type, upload_time
         FROM uploaded_files
         WHERE user_id = ?
         ORDER BY id DESC"
    );
    $statement->execute([$userId]);
}

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
        <?php if ($isAdmin): ?><th>사용자</th><?php endif; ?>
        <th>파일명</th>
        <th>파일 형식</th>
        <th>업로드 시간</th>
        <th>관리</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($files === []): ?>
        <tr><td colspan="<?= $isAdmin ? 6 : 5 ?>" class="empty">등록된 파일이 없습니다.</td></tr>
    <?php else: ?>
        <?php foreach ($files as $file): ?>
            <tr>
                <td><?= (int) $file["id"] ?></td>
                <?php if ($isAdmin): ?>
                    <td><?= htmlspecialchars($file["username"], ENT_QUOTES, "UTF-8") ?></td>
                <?php endif; ?>
                <td>
                    <a href="../uploads/<?= rawurlencode($file["file_name"]) ?>"
                       target="_blank" rel="noopener noreferrer">
                        <?= htmlspecialchars($file["file_name"], ENT_QUOTES, "UTF-8") ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($file["file_type"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($file["upload_time"], ENT_QUOTES, "UTF-8") ?></td>
                <td>
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
