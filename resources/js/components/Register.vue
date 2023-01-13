<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import user from '../stores/user';
import Popup from './Popup.vue';
import InputText from './InputText.vue';

const fields = reactive({
    email: '',
    name: '',
    password: ''
});

const errors = ref(null);

const isOpen = ref(false);

const togglePopup = () => {
    isOpen.value = !isOpen.value;
    fields.email = fields.name = fields.password = '';
    errors.value = null;
}

const register = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        const { data } = await axios.post('/api/register', fields);
        user.name = data.name;
        user.email = data.email;
        togglePopup();
    } catch (error) {
        errors.value = error.response.data.errors;
    }
}
</script>

<template>
    <button @click="togglePopup">register</button>
    <Popup :isOpen="isOpen" :close="togglePopup">
        <form class="popup_login">
            <InputText v-model="fields.email" placeholder="example@mail.com" type="email" name="email"/>
            <InputText v-model="fields.name" placeholder="username" type="text" name="name"/>
            <InputText v-model="fields.password" placeholder="password" type="password" name="password"/>
            <Transition name="errors">
                <div v-if="errors" class="popup_login_errors">
                    <p v-for="value in errors">{{value[0]}}</p>
                </div>
            </Transition>
            <button @click.prevent="register" class="button-secondary">register</button>
        </form>
    </Popup>
</template>
