const sidebar       = document.getElementById('sidebar')
const sidebarToggle = document.getElementById('sidebar-toggle')

sidebarToggle.onclick = () => {
    sidebar.classList.toggle('sidebar--active')
}
