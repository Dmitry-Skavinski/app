<script setup>
import { ref } from 'vue';
import user from '../stores/user';
import Popup from './Popup.vue';

const isPopupOpen = ref(false);

const togglePopup = () => {
    isPopupOpen.value = !isPopupOpen.value
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
                <button @click="togglePopup">login</button>
                <button>register</button>  
                <Popup :isOpen="isPopupOpen" :close="togglePopup">
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
</style>
