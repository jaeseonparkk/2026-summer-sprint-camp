<?php
require_once "../config/db.php";

$sql = "
SELECT
uploaded_files.id,
users.username,
uploaded_files.file_name,
uploaded_files.file_type,
uploaded_files.upload_time
FROM uploaded_files
JOIN users
ON uploaded_files.user_id = users.id
ORDER BY uploaded_files.id DESC
";

$result = mysqli_query($conn, $sql);

echo "
<table border='1'>
<tr>
<th>파일번호</th>
<th>업로드한 사용자</th>
<th>파일명</th>
<th>파일 형식</th>
<th>업로드 시간</th>
</tr>
";

while($row = mysqli_fetch_assoc($result)){

    echo "<tr>";

    echo "<td>{$row['id']}</td>";

    echo "<td>{$row['username']}</td>";

    echo "<td>{$row['file_name']}</td>";

    echo "<td>{$row['file_type']}</td>";

    echo "<td>{$row['upload_time']}</td>";

    echo "</tr>";
}

echo "</table>";
?>