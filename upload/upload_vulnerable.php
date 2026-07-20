<?php
session_start();
require_once "../config/db.php";

$uploadDir = "../uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES["file"])) {

        $fileName = basename($_FILES["file"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {

            $userId = $_SESSION["user_id"];

            $sql = "INSERT INTO uploaded_files(user_id, file_name, file_type)
                    VALUES ('$userId', '$fileName', '$fileType')";

            mysqli_query($conn, $sql);

            echo "파일 업로드 성공";

        } else {
            echo "파일 업로드 실패";
        }

    } else {
        echo "파일이 선택되지 않았습니다.";
    }

} else {
    echo "잘못된 접근입니다.";
}

?>