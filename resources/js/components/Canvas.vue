<script setup>
import { reactive, ref } from 'vue';
const { mode, height, width } = defineProps(['mode', 'height', 'width']);

const initialState = Array(height).fill(0).map(el => Array(width).fill(0));

const state = reactive(initialState);
const scale = ref(1);
const path = reactive({
    toState: 1,
    initialX: 0,
    initialY: 0,
    isActive: false
});

const startDrawing = (cell, x, y) => {
    console.log(cell, x, y);
    path.initialX = x;
    path.initialY = y;
    path.toState = cell ? 0 : 1;
    path.isActive = true;
    draw(x, y);
}

const stopDrawing = () => {
    path.isActive = false;
}

const draw = (x, y) => {
    if (!path.isActive) return;
    switch (mode) {
        case 'draw' : state[y][x] = path.toState;
        break;
    }
    
}

const resize = (event) => {
    scale.value = event.target.value
}

const generateBorders = (row, column) => {
    const styles = {};
    if (!((row + 1) % 5)) {
        styles['border-bottom'] = '1px solid var(--accent-border)'
    }
    if (!(row % 5)) {
        styles['border-top'] = 'none'
    }
    if (!((column + 1) % 5)) {
        styles['border-right'] = '1px solid var(--accent-border)'
    }
    if (!(column % 5)) {
        styles['border-left'] = 'none'
    }
    if (column + 1 === width) {
        styles['border-right'] = 'none'
    }
    if (row + 1 === height) {
        styles['border-bottom'] = 'none'
    }
    return styles;
}

const generateCellClass = (cellValue) => {
    switch (cellValue) {
        case 0: return 'cell__empty';
        case 1: return 'cell__colored';
        case 2: return 'cell__excluded'
    }
}
</script>

<template>
    <div class="canvas_wrapper">
        <div class="canvas" :style="`transform: scale(${scale})`" @mouseup="stopDrawing" @mouseleave="stopDrawing">
            <div v-for="(row, rowKey) in state" class="row">
                <div
                v-for="(cell, columnKey) in row"
                class="cell"
                :class="generateCellClass(cell)"
                :style="generateBorders(rowKey, columnKey)"
                @mousedown="event => startDrawing(cell, columnKey, rowKey)"
                @mouseover="event => draw(columnKey, rowKey)"
                />
            </div>
        </div>
    </div>
    <div class="canvas_controls">
        Scale: 
        <input type="range" min="0.5" max="10" @input="resize" :value="scale" step="0.1"/>
    </div>
</template>

<style lang="scss">
.canvas {
    display: flex;
    flex-direction: column;
    height: max-content;
    width: max-content;
    transform-origin: top left;
    border: 1px solid $primary;
    user-select: none;

    &_wrapper {
        width: 100%;
        overflow: scroll;
        display: flex;
        grid-area: canvas;
    }

    .row {
        display: flex;

        .cell {
            --accent-border: #{$primary};
            width: 16px;
            height: 16px;
            background-color: $background-secondary;
            border-right: 1px solid grey;
            border-bottom: 1px solid grey;

            &__colored {
                background-color: black;
            }
        }
    }

    &_controls {
        width: min-content;
        grid-area: controls;

        input {
            width: 100px;
        }
    }
}
</style>