<script setup>
import { ref } from 'vue';
import user from '../stores/user';
import Login from './Login.vue';
import Popup from './Popup.vue';
import Register from './Register.vue';

const isLoginPopupOpen = ref(false);

const toggleLoginPopup = () => {
    isLoginPopupOpen.value = !isLoginPopupOpen.value
}

const isRegisterPopupOpen = ref(false);

const toggleRegisterPopup = () => {
    isRegisterPopupOpen.value = !isRegisterPopupOpen.value
}

</script>

<template>
    <header>
        <nav>
            <RouterLink to="/list">nonograms</RouterLink>
            <RouterLink to="/create">create nonogram</RouterLink>
        </nav>
        <div class="actions">
            <template v-if="!Object.keys(user).length">
                <button @click="toggleLoginPopup">login</button>
                <button @click="toggleRegisterPopup">register</button>  
                <Popup :isOpen="isLoginPopupOpen" :close="toggleLoginPopup">
                    <Login/>
                </Popup>
                <Popup :isOpen="isRegisterPopupOpen" :close="toggleRegisterPopup">
                    <Register/>
                </Popup>
            </template>
            <RouterLink v-else to="/me">profile</RouterLink>
        </div>
    </header>
</template>

<style lang="scss">
    header {
        background-color: $primary;
        display: grid;
        grid-template-columns: 1fr max-content;
        gap: 10px;
        height: 70px;
        align-items: center;
        padding-inline: 20px;

        .actions {
            display: flex;
            gap: 10px
        }

        nav {
            display: flex;
            gap: 10px;
        }

        a {
            color: $secondary;
            text-transform: uppercase;
        }
    }

    .popup_login {
        min-height: 40vh;
        display: grid;
        background-color: $background-secondary;
        min-width: 40vw;
        justify-content: space-evenly;
    }
</style>
