function setImage() {
    const imgView = document.getElementById('imgView');
    const imgInput = document.getElementById('imgInput');
    const imgInputWrapper = document.getElementById('imgInputWrapper');
    const noImageCheckbox = document.getElementById('noImage');
    const placeholderImage = 'https://localhost/InstitutoRaiz/public/assets/images/vectors/icons/user-placeholder-vector.svg'; // caminho para a imagem placeholder

  if (imgInput) {
      imgInput.addEventListener('change', function () {
          const file = imgInput.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function (e) {
                  imgView.src = e.target.result;
              };
              reader.readAsDataURL(file);
          }
      });
  }

    if (noImageCheckbox) {
        noImageCheckbox.addEventListener('change', function () {
            if (noImageCheckbox.checked) {
                imgView.src = placeholderImage;
                imgInput.value = ''; // Limpa o campo de input de arquivo
                imgInputWrapper.classList.replace('flex', 'display-none')
            } else {
                imgInputWrapper.classList.replace('display-none', 'flex')
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', setImage);
