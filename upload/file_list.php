<?php
/*
===========================================
파일명 : upload/file_list.php
역할 : 업로드된 파일 목록 조회
기능 :
- 관리자 : 모든 파일 조회
- 일반 사용자 : 본인 파일만 조회
===========================================
*/

session_start();

// DB 연결
require_once "../config/db.php";

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {

    echo "로그인이 필요합니다.";
    exit;

}

$userId = $_SESSION['user_id'];
$userRole = $_SESSION['role'];

// ===========================
// 파일 목록 조회
// ===========================

// 관리자
if ($userRole === 'admin') {

    $sql = "
    SELECT uploaded_files.id,
           users.username,
           uploaded_files.file_name,
           uploaded_files.file_type,
           uploaded_files.upload_time
    FROM uploaded_files
    JOIN users
    ON uploaded_files.user_id = users.id
    ORDER BY uploaded_files.id DESC
    ";

    $stmt = $pdo->query($sql);

}
// 일반 사용자
else{

    $sql = "
    SELECT id,
           file_name,
           file_type,
           upload_time
    FROM uploaded_files
    WHERE user_id = ?
    ORDER BY id DESC
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$userId]);

}

?>

<!DOCTYPE html>

<html lang="ko">

<head>

<meta charset="UTF-8">

<link rel="stylesheet" href="../css/style.css">

</head>

<body>

<table class="upload-table">

<tr>

    <th>번호</th>

    <?php if($userRole === 'admin'): ?>
        <th>사용자</th>
    <?php endif; ?>

    <th>파일명</th>

    <th>파일 형식</th>

    <th>업로드 시간</th>

    <th>관리</th>

</tr>

<?php

// 업로드된 파일이 없는 경우
if($stmt->rowCount() == 0){

?>

<tr>

    <td colspan="<?php echo ($userRole === 'admin') ? 6 : 5; ?>" class="empty">

        등록된 파일이 없습니다.

    </td>

</tr>

<?php

}else{

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

?>

<tr>

    <td><?php echo $row['id']; ?></td>

    <?php if($userRole === 'admin'): ?>

        <td><?php echo htmlspecialchars($row['username']); ?></td>

    <?php endif; ?>

    <td>
        <a
            href="../uploads/<?php echo rawurlencode($row['file_name']); ?>"
            target="_blank"
        >
            <?php echo htmlspecialchars($row['file_name']); ?>
        </a>
    </td>

    <td><?php echo htmlspecialchars($row['file_type']); ?></td>

    <td><?php echo $row['upload_time']; ?></td>

    <td>

        <form
            method="POST"
            action="delete_file.php"
        >

            <input
                type="hidden"
                name="file_id"
                value="<?php echo $row['id']; ?>"
            >

            <button
                type="submit"
                class="delete-btn"
            >
                삭제
            </button>

        </form>

    </td>

</tr>

<?php

    }

}

?>

</table>

</body>

</html>