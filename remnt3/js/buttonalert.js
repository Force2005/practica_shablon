let submitButton = document.getElementById("submit-button");
submitButton.addEventListener("click", function (event) {
  // Добавляем event.preventDefault() для отмены действия по умолчанию
  event.preventDefault();
  // Если все input заполнены, вызываем showAlert
  if (areAllInputsFilled()) {
    showAlert();
  }
});