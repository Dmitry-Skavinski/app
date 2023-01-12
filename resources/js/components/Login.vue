<script setup>
import { reactive } from 'vue';
import axios from 'axios';
import user from '../stores/user';
const fields = reactive({
    login: '',
    password: ''
});

const login = async () => {
    await axios.get('/sanctum/csrf-cookie');
    const { data } = await axios.post('/api/login', fields);
    user.name = data.name;
    user.email = data.email;
}
</script>

<template>
    <form class="popup_login">
        <input v-model="fields.login" placeholder="username or email"/>
        <input v-model="fields.password" type="password" placeholder="password"/>
        <button @click.prevent="login" class="button-secondary">login</button>
    </form>
</template>