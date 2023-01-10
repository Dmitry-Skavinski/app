<script setup>
import { reactive } from 'vue';
import axios from 'axios';

const fields = reactive({
    email: '',
    name: '',
    password: ''
});

const response = reactive({data: {}});

const register = async () => {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/register', fields);
}
</script>

<template>
    <form class="popup_login">
        <input v-model="fields.email" type="email" placeholder="exmaple@gmail.com"/>
        <input v-model="fields.name" placeholder="username"/>
        <input v-model="fields.password" type="password" />
        <button @click.prevent="register" class="button-secondary">register</button>
        <button class="button-secondary">login</button>
    </form>
</template>

<style lang="scss">
.popup_login {
    min-height: 40vh;
    display: grid;
    background-color: $background-secondary;
    min-width: 40vw;
    justify-content: space-evenly;
}
</style>