const modal = document.getElementById('modal');
const openModal = document.querySelector('.open-button');
const closeModal = document.getElementById('close-button');

if (openModal) {
    openModal.addEventListener('click', () => {
        modal.showModal();
    });
}
if (closeModal) {
    closeModal.addEventListener('click', () => {
        modal.close();
    });
}

if (modal) {
    document.addEventListener('DOMContentLoaded', () => {
        modal.showModal();
    });
}

const sidebar = document.getElementById('sidebar');
const openSidebar = document.querySelector('.open-sidebar-profile-button');
const closeSidebar = document.querySelector('.close-sidebar-button');

if (openSidebar) {
    openSidebar.addEventListener('click', () => {
        sidebar.showModal();
    });
}
if (closeSidebar) {
    closeSidebar.addEventListener('click', () => {
        sidebar.close();
    });
}

if (sidebar) {
    // Flags para controlar o estado do mouse
    let mouseInsideSidebar = false;
    let sidebarClosing = false;

    // Fechar o sidebar ao clicar fora dele
    sidebar.addEventListener('click', (event) => {
        if (event.target == sidebar) {
            sidebar.setAttribute('closing', "");
            sidebar.addEventListener('animationend', () => {
                sidebar.removeAttribute('closing');
                sidebar.close();
                sidebarClosing = false;
            }, { once: true });
            sidebarClosing = true;
        }
    });

    // Detectar quando o mouse entra e sai do sidebar
    sidebar.addEventListener('mouseenter', () => {
        mouseInsideSidebar = true;
    });
    sidebar.addEventListener('mouseleave', () => {
        mouseInsideSidebar = false;
        // Fechar o sidebar apenas se ele estiver visível e não estiver no processo de fechamento
        if (sidebar.open && !sidebarClosing) {
            sidebar.setAttribute('closing', "");
            sidebar.addEventListener('animationend', () => {
                sidebar.removeAttribute('closing');
                sidebar.close();
            }, { once: true });
        }
    });

    // Fechar o sidebar quando o mouse estiver fora dele e ele estiver aberto
    document.addEventListener('mousemove', (event) => {
        const sidebarRect = sidebar.getBoundingClientRect();
        const mouseX = event.clientX;

        // Verifica se o mouse está fora da área do sidebar (à esquerda do sidebar)
        if (mouseX > sidebarRect.left && sidebar.open && !mouseInsideSidebar && !sidebarClosing) {
            sidebar.setAttribute('closing', "");
            sidebar.addEventListener('animationend', () => {
                sidebar.removeAttribute('closing');
                sidebar.close();
            }, { once: true });
        }
    });
}
