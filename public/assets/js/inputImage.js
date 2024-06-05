function setImage() {
    const imgView = document.getElementById('imgView');
    const imgInput = document.getElementById('imgInput');
    const noImageCheckbox = document.getElementById('noImage');
    const placeholderImage = 'https://localhost/InstitutoRaiz/public/assets/images/vectors/icons/user-placeholder-vector.svg'; // caminho para a imagem placeholder

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

    noImageCheckbox.addEventListener('change', function () {
        if (noImageCheckbox.checked) {
            imgView.src = placeholderImage;
            imgInput.value = ''; // Limpa o campo de input de arquivo
            imgInput.style.display = 'none'; // Esconde o input de arquivo
        } else {
            imgInput.style.display = 'block'; // Mostra o input de arquivo novamente
        }
    });
}

document.addEventListener('DOMContentLoaded', setImage);
