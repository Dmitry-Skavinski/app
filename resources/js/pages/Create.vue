<script setup>
import { ref } from 'vue';
import Canvas from '../components/Canvas.vue';
import user from '../stores/user';

const scale = ref(1);

const resize = (event) => {
    scale.value = event.target.value
}
</script>

<template>
    <main v-if="!Object.keys(user).length" class="route-create">
        <h1>You need to login first</h1>
    </main>
    <main v-if="Object.keys(user).length" class="route-create">
        <div class="canvas_wrapper">
            <Canvas mode="default" :height="15" :width="10" :scale="scale"/>  
        </div>
        <div class="canvas_controls">
            Scale: 
            <input type="range" min="0.5" max="10" @input="resize" :value="scale" step="0.1"/>
        </div>
    </main>
</template>

<style lang="scss">
.route-create {
    display: grid;
    grid-template-areas:
    'controls'
    'canvas';
    grid-template-rows: min-content 1fr;
    padding: 20px;

    .canvas {
        &_wrapper {
            width: 100%;
            overflow: scroll;
            display: flex;
            grid-area: canvas;
        }

        &_controls {
            width: min-content;
            grid-area: controls;

            input {
                width: 100px;
            }
        }
    }
}
</style>