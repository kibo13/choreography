<template>
    <h2 class="auth-title">{{ title }}</h2>
    <div v-if="isError" class="auth-alert">
        {{ errors[0] }}
    </div>
    <form class="auth-form" method="POST" @submit.prevent="login">
        <input type="hidden" name="_token" :value="csrf">
        <div class="auth-form__control" >
            <label class="auth-form__label" for="username">
                Логин
            </label>
            <input class="auth-form__input"
                   :class="isError ? 'auth-form__input--invalid' : ''"
                   id="username"
                   type="text"
                   v-model="username"
                   autocomplete="off"
                   required>
        </div>
        <div class="auth-form__control">
            <label class="auth-form__label" for="password">
                Пароль
            </label>
            <input class="auth-form__input"
                   :class="isError ? 'auth-form__input--invalid' : ''"
                   id="password"
                   type="password"
                   v-model="password"
                   autocomplete="off"
                   required>
        </div>
        <button class="auth-form__button">
            {{ title }}
        </button>
    </form>
</template>

<script>
import axios from 'axios'

export default {
    name: "LoginForm",

    props: {
        title: {
            type: String,
            required: true
        },
        href: {
            type: String,
            required: true
        },
        home: {
            type: String
        }
    },

    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            username: null,
            email: null,
            password: null,
            isError: false,
            errors: []
        }
    },

    methods: {
        login() {
            let data = {
                csrf: this.csrf,
                username: this.username,
                password: this.password
            }

            axios.post(this.href, data)
                .then(() => window.location.href = this.home)
                .catch(error => {
                    this.isError = true
                    this.errors.push(error.response.data.errors.username[0])
                })
        }
    }
}
</script>
