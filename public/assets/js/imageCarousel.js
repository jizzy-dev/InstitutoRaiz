let currentIndex = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.sc2-carousel-item');
    const progressItems = document.querySelectorAll('.progress-item');
    const totalSlides = slides.length;

    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === index) {
            slide.classList.add('active');
        }
    });

    progressItems.forEach((item, i) => {
        item.classList.remove('active');
        if (i === index) {
            item.classList.add('active');
        }
    });

    currentIndex = index;
}

function prevSlide() {
    const slides = document.querySelectorAll('.sc2-carousel-item');
    let index = currentIndex - 1;

    if (index < 0) {
        index = slides.length - 1;
    }

    showSlide(index);
}

function nextSlide() {
    const slides = document.querySelectorAll('.sc2-carousel-item');
    let index = currentIndex + 1;

    if (index >= slides.length) {
        index = 0;
    }

    showSlide(index);
}

// Inicia mostrando o primeiro slide
showSlide(currentIndex);

// Adiciona evento para troca automática de slides a cada 5 segundos
let autoSlideInterval = setInterval(nextSlide, 5000);

// Torna as barras de progresso clicáveis
document.querySelectorAll('.progress-item').forEach((item, index) => {
    item.addEventListener('click', () => {
        clearInterval(autoSlideInterval); // Parar o slide automático ao clicar
        showSlide(index);
        autoSlideInterval = setInterval(nextSlide, 5000); // Reiniciar o slide automático após clique
    });
});
