document.addEventListener("DOMContentLoaded", () => {
  loadFiles();
});

function loadFiles() {
  fetch("upload/file_list.php")
    .then(res => res.json())
    .then(data => {
      const fileList = document.getElementById("files");
      fileList.innerHTML = "";
      data.forEach(file => {
        const li = document.createElement("li");
        li.textContent = `${file.file_name} (${file.file_type})`;

        const delBtn = document.createElement("button");
        delBtn.textContent = "삭제";
        delBtn.onclick = () => deleteFile(file.id);

        li.appendChild(delBtn);
        fileList.appendChild(li);
      });
    });
}

function deleteFile(fileId) {
  fetch("upload/delete_file.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `file_id=${fileId}`
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      loadFiles();
    });
}
