const authModal = document.getElementById('auth')
const authBtn   = document.getElementById('auth-sign')

authBtn.onclick = (event) => authModal.style.top = '0'
window.onclick  = (event) => {
    if (event.target === authModal) {
        authModal.style.top = '-100%'
    }
}
