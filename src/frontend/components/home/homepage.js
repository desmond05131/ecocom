// Sticky navbar scroll effect
window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".nav-bar");
    const scrollY = window.scrollY;
  
    if (scrollY > 60) {
      navbar.classList.add("sticky");
    } else {
      navbar.classList.remove("sticky");
    }
  });
  