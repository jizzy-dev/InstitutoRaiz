const modal = document.getElementById('modal');
const openModal = document.querySelector('.open-button');
const closeModal = document.getElementById('close-button');

if (openModal) {
    openModal.addEventListener('click', () => {
        modal.showModal();
    })
}
if (closeModal) {
    closeModal.addEventListener('click', () => {
        modal.close();
    })
}

if (modal) {
    document.addEventListener('DOMContentLoaded', () => {
        modal.showModal();
    });
}
const sidebar = document.getElementById('sidebar');
const sidebarBackdrop = document.querySelector('.sidebar::backdrop');
const openSidebar = document.querySelector('.open-sidebar-profile-button');
const closeSidebar = document.querySelector('.close-sidebar-button');

if (openSidebar) {
    openSidebar.addEventListener('click', () => {
        sidebar.showModal();
    })
}
if (closeSidebar) {
    closeSidebar.addEventListener('click', () => {
        sidebar.close();
    })
}
if (sidebar) {
    sidebar.addEventListener('click', (event) => {
        if (event.target == sidebar) {
            sidebar.setAttribute('closing', "");
            sidebar.addEventListener('animationend', () => {
                sidebar.removeAttribute('closing');
                sidebar.close();
            }, { once: true })
        }
    })
    sidebar.addEventListener('mouseover', (event) => {
        if (event.target == sidebar) {
            sidebar.setAttribute('closing', "");
            sidebar.addEventListener('animationend', () => {
                sidebar.removeAttribute('closing');
                sidebar.close();
            }, { once: true })
        }
    })
}