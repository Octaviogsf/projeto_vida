let currentIndex = 0;

const images = document.querySelectorAll('.carousel img');
const totalImages = images.length;

function updateCarousel() {
    const offset = -currentIndex * 100; // Calcula o deslocamento
    const carousel = document.querySelector('.carousel');
    carousel.style.transform = `translateX(${offset}%)`;
}

function moveCarousel() {
    currentIndex = (currentIndex + 1) % totalImages; // Avança para a próxima imagem, reiniciando no início
    updateCarousel();
}

// Inicializa o carrossel
updateCarousel();

// Faz o carrossel se mover automaticamente a cada 3 segundos (3000 milissegundos)
setInterval(moveCarousel, 6500);
