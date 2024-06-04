const modal = document.getElementById('modal');
const openModal = document.querySelector('.open-button');
const closeModal = document.querySelector('.close-button');

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
const openSidebar = document.querySelector('.open-sidebar-button');
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