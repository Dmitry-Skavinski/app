<script setup>
import { reactive, ref } from 'vue';
import axios from 'axios';
import user from '../stores/user';
import Popup from './Popup.vue';
import InputText from './InputText.vue';

const fields = reactive({
    login: '',
    password: ''
});

const errors = ref(null);

const isOpen = ref(false);

const togglePopup = () => {
    isOpen.value = !isOpen.value;
    fields.login = fields.password = '';
    errors.value = null;
}

const login = async () => {
    try {
        await axios.get('/sanctum/csrf-cookie');
        const { data } = await axios.post('/api/login', fields);
        if ( data ) {
            user.name = data.name;
            user.email = data.email;
        }
        togglePopup();
    } catch (error) {
        errors.value = error.response.data.errors;
    }
}
</script>

<template>
    <button @click="togglePopup">login</button>
    <Popup :isOpen="isOpen" :close="togglePopup">
        <form class="popup_login">
        <InputText v-model="fields.login" placeholder="username or email" type="text" name="login"/>
        <InputText v-model="fields.password" placeholder="password" type="password" name="password"/>
        <Transition name="errors">
            <div v-if="errors" class="popup_login_errors">
                <p v-for="value in errors">{{value[0]}}</p>
            </div>
        </Transition>
        <button @click.prevent="login" class="button-secondary">login</button>
    </form>
    </Popup>
</template>