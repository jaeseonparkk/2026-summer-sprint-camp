<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>파일 업로드</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>파일 업로드</h1>
  <form id="uploadForm" action="upload/upload_vulnerable.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" required />
    <button type="submit">업로드</button>
  </form>
</body>
</html>