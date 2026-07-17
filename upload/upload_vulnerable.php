<?php

$uploadDir = "../uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES["file"])) {

        $fileName = basename($_FILES["file"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
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