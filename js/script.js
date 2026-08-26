document.addEventListener("DOMContentLoaded", () => {
  const alert = document.getElementById("uploadAlert");
  const closeButton = alert?.querySelector(".upload-alert-close");

  closeButton?.addEventListener("click", () => alert.remove());
});
