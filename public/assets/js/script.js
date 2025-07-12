// --- Mobile menu toggle ---
const btn = document.getElementById("mobile-menu-btn");
const menu = document.getElementById("mobile-menu");

if (btn && menu) {
  btn.addEventListener("click", () => {
    menu.classList.toggle("hidden");
  });
}

// --- Hero carousel logic (Hanya untuk index.html) ---
const carouselContainer = document.getElementById("hero-carousel");
if (carouselContainer) {
    const carousel = document.getElementById("carousel");
    const slides = carousel.querySelectorAll("article");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    let currentIndex = 0;
    const totalSlides = slides.length;

    function updateCarousel() {
      carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    prevBtn.addEventListener("click", () => {
      currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
      updateCarousel();
    });

    nextBtn.addEventListener("click", () => {
      currentIndex = (currentIndex + 1) % totalSlides;
      updateCarousel();
    });

    let autoSlide = setInterval(() => {
      nextBtn.click();
    }, 6000);

    carouselContainer.addEventListener("mouseenter", () => clearInterval(autoSlide));
    carouselContainer.addEventListener("mouseleave", () => {
      autoSlide = setInterval(() => nextBtn.click(), 6000);
    });
    
    updateCarousel();
}


// --- Intersection Observer untuk animasi section saat scroll ---
const sections = document.querySelectorAll("section:not(#hero-carousel)");
const observerOptions = {
  threshold: 0.2
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const section = entry.target;
      const index = Array.from(sections).indexOf(section);
      
      if (index % 2 === 0) {
        section.classList.add("animate-slide-in-left");
      } else {
        section.classList.add("animate-slide-in-right");
      }
      section.classList.remove("opacity-0");
      observer.unobserve(section);
    }
  });
}, observerOptions);

sections.forEach((section) => {
  observer.observe(section);
});