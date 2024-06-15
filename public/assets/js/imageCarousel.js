function createCarousel(carouselContainer) {
    let currentIndex = 0;
    const slides = carouselContainer.querySelectorAll('.carousel-item');
    const progressItems = carouselContainer.querySelectorAll('.progress-item');
    const totalSlides = slides.length;

    function showSlide(index) {
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
        let index = currentIndex - 1;
        if (index < 0) {
            index = totalSlides - 1;
        }
        showSlide(index);
    }

    function nextSlide() {
        let index = currentIndex + 1;
        if (index >= totalSlides) {
            index = 0;
        }
        showSlide(index);
    }

    // Inicia mostrando o primeiro slide
    showSlide(currentIndex);

    // Adiciona evento para troca automática de slides a cada 5 segundos
    let autoSlideInterval = setInterval(nextSlide, 5000);

    // Torna as barras de progresso clicáveis
    progressItems.forEach((item, index) => {
        item.addEventListener('click', () => {
            clearInterval(autoSlideInterval); // Parar o slide automático ao clicar
            showSlide(index);
            autoSlideInterval = setInterval(nextSlide, 5000); // Reiniciar o slide automático após clique
        });
    });

    slides.forEach((slide, index) => {
        let startX, currentX;

        slide.addEventListener('dragstart', (e) => {
            startX = e.clientX;
        });

        slide.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        slide.addEventListener('drop', (e) => {
            currentX = e.clientX;
            if (currentX < startX) {
                // Arrastou para a esquerda, avança o slide
                nextSlide();
            } else if (currentX > startX) {
                // Arrastou para a direita, retrocede o slide
                prevSlide();
            }
        });
    });


    // Expor funções de navegação
    return { nextSlide, prevSlide };
}

// Inicializar todos os carrosséis na página
document.querySelectorAll('.carousel-container').forEach(container => {
    createCarousel(container);
});
