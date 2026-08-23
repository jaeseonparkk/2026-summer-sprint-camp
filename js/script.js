// 페이지의 HTML이 모두 로드된 후 실행
document.addEventListener("DOMContentLoaded", () => {

  const fileList = document.getElementById("files");

  // 파일 목록 영역이 있는 페이지에서만 파일 목록 조회
  if (fileList) {
    loadFiles();
  }

  const uploadAlert = document.getElementById("uploadAlert");
  const closeButton = document.querySelector(".upload-alert-close");

  // 업로드 결과 알림의 닫기 버튼 처리
  if (uploadAlert && closeButton) {
    closeButton.addEventListener("click", () => {
      uploadAlert.remove();
    });
  }
});


// 업로드된 파일 목록 조회
function loadFiles() {

  const fileList = document.getElementById("files");

  // 파일 목록 영역이 없는 페이지에서는 실행하지 않음
  if (!fileList) {
    return;
  }

  fetch("upload/file_list.php")
    .then(res => res.json())
    .then(data => {

      // 기존 목록 초기화
      fileList.innerHTML = "";

      // 조회한 파일을 하나씩 목록에 추가
      data.forEach(file => {

        const li = document.createElement("li");
        li.textContent = `${file.file_name} (${file.file_type})`;

        // 파일 삭제 버튼 생성
        const delBtn = document.createElement("button");
        delBtn.type = "button";
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


// 업로드된 파일 삭제
function deleteFile(fileId) {

  // 삭제할 파일 ID를 delete_file.php로 전달
  fetch("upload/delete_file.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: `file_id=${encodeURIComponent(fileId)}`
  })
    .then(res => res.text())
    .then(msg => {

      // 삭제 결과를 알림으로 표시
      alert(msg);

      // 삭제 후 파일 목록 다시 조회
      loadFiles();
    })
    .catch(error => {
      console.error("파일 삭제에 실패했습니다.", error);
    });
}