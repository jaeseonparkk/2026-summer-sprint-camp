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

  <!-- 파일 업로드 폼 -->
  <section id="upload-section">
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
