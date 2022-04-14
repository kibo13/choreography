import { createApp } from 'vue'
import LoginForm from './components/LoginForm'

const app       = createApp({})
const authModal = document.getElementById('auth-modal')
const authBtn   = document.getElementById('auth-sign')

app.component('login-form', LoginForm)

app.mount('#auth-modal')

authBtn.onclick = (event) => authModal.style.top = '0'
window.onclick  = (event) => {
    if (event.target === authModal) {
        authModal.style.top = '-100%'
    }
}
