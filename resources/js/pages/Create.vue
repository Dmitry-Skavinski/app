<script setup>
import Canvas from '../components/Canvas.vue';
import user from '../stores/user';
</script>

<template>
    <main v-if="!Object.keys(user).length" class="route-create">
        <h1>You need to login first</h1>
    </main>
    <main v-if="Object.keys(user).length" class="route-create">
        <Canvas mode="draw" :height="15" :width="10"/>
    </main>
</template>

<style>
.route-create {
    display: grid;
    grid-template-areas:
    'controls'
    'canvas';
    grid-template-rows: min-content 1fr;
    padding: 20px;
}
</style>
