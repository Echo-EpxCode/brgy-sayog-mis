const sidebar = document.getElementById('sidebar');

const overlay = document.getElementById('overlay');

function toggleSidebar() {
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
}

function closeSidebar() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
}
