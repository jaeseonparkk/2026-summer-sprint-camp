<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo "로그인이 필요합니다.";
    exit;
}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

if ($userRole === 'admin') {
    // 관리자: 모든 파일 조회
    $sql = "
    SELECT uploaded_files.id, users.username, uploaded_files.file_name,
           uploaded_files.file_type, uploaded_files.upload_time
    FROM uploaded_files
    JOIN users ON uploaded_files.user_id = users.id
    ORDER BY uploaded_files.id DESC
    ";
    $stmt = $pdo->query($sql);
} else {
    // 일반 사용자: 본인 파일만 조회
    $sql = "
    SELECT id, file_name, file_type, upload_time
    FROM uploaded_files
    WHERE user_id = ?
    ORDER BY id DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userId]);
}

echo "<table border='1'>
<tr>
<th>파일번호</th>";
if ($userRole === 'admin') echo "<th>업로드한 사용자</th>";
echo "<th>파일명</th>
<th>파일 형식</th>
<th>업로드 시간</th>
<th>관리</th>
</tr>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    if ($userRole === 'admin') echo "<td>{$row['username']}</td>";
    echo "<td>{$row['file_name']}</td>";
    echo "<td>{$row['file_type']}</td>";
    echo "<td>{$row['upload_time']}</td>";
    echo "<td>
            <form method='POST' action='delete_file.php'>
              <input type='hidden' name='file_id' value='{$row['id']}'>
              <button type='submit'>삭제</button>
            </form>
          </td>";
    echo "</tr>";
}
echo "</table>";
?>
