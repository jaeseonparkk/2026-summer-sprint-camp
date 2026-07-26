<?php
session_start();
require_once "config/db.php";

// 관리자 권한 체크
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "관리자만 접근 가능합니다.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>관리자 페이지</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js" defer></script>
</head>
<body>
  <h1>관리자 페이지</h1>

  <!-- 사용자 관리 -->
  <section id="user-section">
    <h2>사용자 목록</h2>
    <table border="1">
      <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
      <?php
      // 사용자 목록 불러오기
      $sql = "SELECT id, username, role FROM users ORDER BY id ASC";
      $result = $pdo->query($sql);
      while($row = $result->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>";
          echo "<td>{$row['id']}</td>";
          echo "<td>{$row['username']}</td>";
          echo "<td>{$row['role']}</td>";
          echo "<td>
                  <form method='POST' action='admin_action.php'>
                    <input type='hidden' name='user_id' value='{$row['id']}'>
                    <button type='submit' name='action' value='suspend'>정지</button>
                    <button type='submit' name='action' value='delete'>삭제</button>
                  </form>
                </td>";
          echo "</tr>";
      }
      ?>
    </table>
  </section>

  <!-- 파일 업로드 -->
  <section id="upload-section">
    <h2>파일 업로드</h2>
    <form id="uploadForm" action="upload/upload_vulnerable.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="file" required />
      <button type="submit">업로드</button>
    </form>
  </section>

  <!-- 업로드된 파일 목록 -->
  <section id="file-list">
    <h2>업로드된 파일 목록</h2>
    <ul id="files"></ul>
  </section>
</body>
</html>
