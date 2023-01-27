<script setup>
import user from '../stores/user';
import Login from './Login.vue';
import Register from './Register.vue';
</script>

<template>
    <header>
        <nav>
            <RouterLink to="/">nonograms</RouterLink>
            <RouterLink to="/create">create nonogram</RouterLink>
        </nav>
        <div class="actions">
            <template v-if="!Object.keys(user).length">
                <Login/>
                <Register/>
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
        &_errors {
            font-size: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 116px;
            width: 200px;
            overflow: hidden;

            p {
                margin-block: 0;
                text-transform: lowercase;
            }
        }

        .errors {
            &-enter {
                &-active {
                    transition: all 0.3s ease;
                }
                
                &-from {
                    height: 0px;
                }

                &-to {
                    height: 116px;
                }
            }
        }

        button {
            color: $background-secondary;
            width: 200px;
        }
    }
</style>
