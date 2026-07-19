<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>파일 업로드</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>파일 업로드</h1>
  
  <!-- 업로드 폼 -->
  <form id="uploadForm" action="upload/upload_secure.php" method="POST" enctype="multipart/form-data">
    <label for="file">업로드할 파일 선택:</label>
    <input type="file" id="file" name="file" accept=".jpg,.jpeg,.png,.gif,.pdf" required />
    <button type="submit">업로드</button>
  </form>

  <!-- 업로드된 파일 목록 보기 -->
  <section>
    <h2>업로드된 파일 목록</h2>
    <iframe src="upload/file_list.php" style="width:100%; height:200px; border:1px solid #ccc;"></iframe>
  </section>
</body>
</html>
