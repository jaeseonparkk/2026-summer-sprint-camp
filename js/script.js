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
  const fileList = document.getElementById("files");

  // 기존 파일 목록 영역이 있는 페이지에서만 실행
  if (fileList) {
    loadFiles();
  }

  const uploadAlert = document.getElementById("uploadAlert");
  const closeButton = document.querySelector(".upload-alert-close");

  if (uploadAlert && closeButton) {
    closeButton.addEventListener("click", () => {
      uploadAlert.remove();
    });
  }
});

// 관리자 페이지 iframe 로딩 문구 처리
  const fileListFrame =
    document.getElementById("adminFileListFrame");

  const fileListLoading =
    document.getElementById("fileListLoading");

  if (fileListFrame && fileListLoading) {
    fileListFrame.addEventListener("load", () => {
      fileListLoading.remove();
    });
  }
});

/* 업로드된 파일 목록 불러오기 */

function loadFiles() {
  const fileList = document.getElementById("files");

  if (!fileList) {
    return;
  }

  fetch("upload/file_list.php")
    .then(res => res.json())
    .then(data => {
      fileList.innerHTML = "";

      data.forEach(file => {
        const li = document.createElement("li");

        li.textContent =
          `${file.file_name} (${file.file_type})`;

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