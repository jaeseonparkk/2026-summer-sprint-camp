/*
===========================================
파일명 : script.js
역할 : 웹사이트 공통 JavaScript
기능 :
- 업로드된 파일 목록 조회
- 업로드된 파일 삭제
- 업로드 결과 알림 닫기
===========================================
*/

document.addEventListener("DOMContentLoaded", () => {
  loadFiles();

  const uploadAlert = document.getElementById("uploadAlert");
  const closeButton = document.querySelector(".upload-alert-close");

  if (uploadAlert && closeButton) {
    closeButton.addEventListener("click", () => {
      uploadAlert.remove();
    });
  }
});


/* 업로드된 파일 목록 불러오기 */

function loadFiles() {
  fetch("upload/file_list.php")
    .then(res => res.json())
    .then(data => {
      const fileList = document.getElementById("files");

      // 현재 페이지에 파일 목록 영역이 없으면 실행 중단
      if (!fileList) {
        return;
      }

      fileList.innerHTML = "";

      data.forEach(file => {
        const li = document.createElement("li");

        li.textContent =
          `${file.file_name} (${file.file_type})`;

        const delBtn = document.createElement("button");

        delBtn.textContent = "삭제";
        delBtn.onclick = () => deleteFile(file.id);

        li.appendChild(delBtn);
        fileList.appendChild(li);
      });
    })
    .catch(error => {
      console.error("파일 목록을 불러오지 못했습니다.", error);
    });
}


/* 업로드된 파일 삭제 */

function deleteFile(fileId) {
  fetch("upload/delete_file.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `file_id=${encodeURIComponent(fileId)}`
  })
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      loadFiles();
    })
    .catch(error => {
      console.error("파일 삭제에 실패했습니다.", error);
    });
}
