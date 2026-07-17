<?php

$uploadDir = "../uploads/";

$files = array_diff(scandir($uploadDir), array('.', '..'));

echo "<ul>";

foreach ($files as $file) {
    echo "<li>$file</li>";
}

echo "</ul>";

?>