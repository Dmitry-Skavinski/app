<script setup>
import { reactive } from 'vue';
import axios from 'axios';
import user from '../stores/user';

const fields = reactive({
    email: '',
    name: '',
    password: ''
});

const register = async () => {
    await axios.get('/sanctum/csrf-cookie');
    const { data } = await axios.post('/api/register', fields);
    user.name = data.name;
    user.email = data.email;
}
</script>

<template>
    <form class="popup_login">
        <input v-model="fields.email" type="email" placeholder="example@gmail.com"/>
        <input v-model="fields.name" placeholder="username"/>
        <input v-model="fields.password" type="password" placeholder="password"/>
        <button @click.prevent="register" class="button-secondary">register</button>
    </form>
</template>
