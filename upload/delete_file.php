<?php

if (isset($_POST["filename"])) {

    $file = "../uploads/" . $_POST["filename"];

    if (file_exists($file)) {

        unlink($file);

        echo "삭제 완료";

    } else {

        echo "파일이 없습니다.";

    }

} else {

    echo "파일명이 없습니다.";

}

?>