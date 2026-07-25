<?php
require_once "../config/db.php";

if(isset($_POST["filename"])){

    $fileName = $_POST["filename"];

    $file = "../uploads/" . $fileName;

    if(file_exists($file)){

        unlink($file);

        $sql = "DELETE FROM uploaded_files
                WHERE file_name='$fileName'";

        mysqli_query($conn,$sql);

        echo "삭제 완료";

    } else {

        echo "파일이 없습니다.";

    }

} else {

    echo "파일명이 없습니다.";

}

?>