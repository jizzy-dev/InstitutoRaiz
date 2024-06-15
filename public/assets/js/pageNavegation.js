document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll(".sections"); // Todas as seções da página
  const progressBar = document.querySelector("#fixed-progress-bar"); // Barra de progresso
  const header = document.querySelector('header');
  let inactivityTimeout;
  let currentHoveredItem = null; // Para armazenar o progressItem atualmente sob o mouse

  function isElement90PercentInViewport(el) {
    if (progressBar) {
      const rect = el.getBoundingClientRect();
      const windowHeight = window.innerHeight || document.documentElement.clientHeight;
      // Verifica se 90% da seção está visível
      return rect.top <= windowHeight * 0.7 && rect.bottom >= windowHeight * 0.5;
    }
  }

  // Função para atualizar o estado ativo do progresso com base na posição da seção visível
  function updateProgress() {
    let activeFound = false;
    sections.forEach((section, index) => {
      if (isElement90PercentInViewport(section) && !activeFound) {
        progressItems.forEach((item, i) => {
          if (i === index) {
            if (!item.classList.contains("active")) {
              item.classList.add("active");
              if (i === 0) {
                hideProgressBar();
              } else {
                showProgressBar();
              }
            }
            activeFound = true;
          } else {
            item.classList.remove("active", "fade-in", "fade-out");
          }
        });
      }
    });

    // Se nenhuma seção foi marcada como ativa, marcar a última seção
    if (!activeFound) {
      progressItems.forEach((item, i) => {
        item.classList.remove("active", "fade-in", "fade-out");
        if (i === sections.length - 1) {
          item.classList.add("active", "fade-in");
        }
      });
    }
  }

  // Função para ocultar a barra de progresso após um período de inatividade
  function hideProgressBar() {
   if (progressBar) {
     progressBar.classList.add("progress-bar-out-left");
     progressBar.classList.remove("progress-bar-in-right");
   }
  }

  // Função para mostrar a barra de progresso
  function showProgressBar() {
   if (progressBar) {
     progressBar.classList.add("progress-bar-in-right");
     progressBar.classList.remove("progress-bar-out-left");
   }
  }

  // Função para reiniciar o temporizador de inatividade
  function resetInactivityTimeout() {
    clearTimeout(inactivityTimeout);
    showProgressBar();
    inactivityTimeout = setTimeout(hideProgressBar, 3000); // 3 segundos de inatividade
  }

  if (progressBar) {
    document.addEventListener("mousemove", function (event) {
      const rect = progressBar.getBoundingClientRect();
      if (
        event.clientX >= rect.left - 100 &&
        event.clientX <= rect.right + 100 &&
        event.clientY >= rect.top - 100 &&
        event.clientY <= rect.bottom + 100
      ) {
        showProgressBar();
        resetInactivityTimeout();
      }
    });
  }

  document.addEventListener("scroll", resetInactivityTimeout);
  window.addEventListener("resize", resetInactivityTimeout);

  // Adicionar eventos de mouseover e mouseout para mostrar e ocultar o título ao lado do progressItem
  const progressItems = document.querySelectorAll(".fixed-progress-item");
  progressItems.forEach((item, index) => {
    item.addEventListener("mouseover", () => {
      // Remove o título de todos os progressItems
      progressItems.forEach(item => {
        const titleSpan = item.querySelector('.progress-title');
        if (titleSpan) {
          titleSpan.remove();
        }
      });

      // Adiciona o título apenas ao item atual
      const titleElement = sections[index].querySelector('.sc-title');
      if (titleElement) {
        const titleSpan = document.createElement('span');
        titleSpan.classList.add('progress-title', 'fade-in');
        titleSpan.textContent = titleElement.textContent;
        item.appendChild(titleSpan);
      }
    });

    item.addEventListener("mouseout", () => {
      // Remove o título ao mover o mouse para fora do progressItem
      const titleSpan = item.querySelector('.progress-title');
      if (titleSpan) {
        titleSpan.remove();
      }
    });

    // Adicionar evento de clique para navegação através dos itens de progresso
    item.addEventListener("click", () => {
      if (index === 0) {
        header.scrollIntoView({ behavior: "smooth" });
      } else {
        sections[index].scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  // Atualizar o estado do progresso ao carregar e rolar a página
  updateProgress();
  window.addEventListener("scroll", updateProgress);
  window.addEventListener("resize", updateProgress);

  // Função para mostrar a barra de progresso se a primeira seção não estiver visível
  if (sections) {
    function checkInitialSectionVisibility() {
      const firstSection = sections[0];
      if (!isElement90PercentInViewport(firstSection)) {
        showProgressBar();
      } else {
        hideProgressBar();
      }
    }
  }

  // Verificar a visibilidade da primeira seção ao carregar a página
  checkInitialSectionVisibility();
});
