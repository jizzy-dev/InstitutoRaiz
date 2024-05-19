document.addEventListener("DOMContentLoaded", function() {
    const sections = document.querySelectorAll("section");
    const buttons = document.querySelectorAll(".btn-nav");
  
    document.addEventListener("mousemove", function(event) {
      sections.forEach((section, index) => {
        const rect = section.getBoundingClientRect();
        const isNear = event.clientY >= rect.top && event.clientY <= rect.bottom;
  
        if (isNear) {
          section.classList.add("show-btns");
        } else {
          section.classList.remove("show-btns");
        }
      });
    });
  });