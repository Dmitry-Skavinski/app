<script setup>
import { reactive } from 'vue';
const { mode, height, width, scale } = defineProps(['mode', 'height', 'width', 'scale']);

const initialState = Array(height).fill(0).map(el => Array(width).fill(0));

const state = reactive(initialState);
const path = reactive({
    toState: 1,
    initialX: 0,
    initialY: 0,
    isActive: false
});

const startDrawing = (cell, x, y, button) => {
    path.initialX = x;
    path.initialY = y;
    path.isActive = true;

    if (button === 0) {
        path.toState = cell === 1 ? 0 : 1; 
    }

    if (button === 2) {
        path.toState = cell === 2 ? 0 : 2;
    }

    draw(x, y);
}

const stopDrawing = () => {
    path.isActive = false;
}

const draw = (x, y) => {
    if (!path.isActive) return;
    switch (mode) {
        case 'default' : state[y][x] = path.toState;
        break;
        case 'lines' : 
    }
    
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
    <div class="canvas" :style="`transform: scale(${scale})`" @mouseup="stopDrawing" @mouseleave="stopDrawing" @contextmenu.prevent="">
        <div v-for="(row, rowKey) in state" class="row">
            <div
            v-for="(cell, columnKey) in row"
            class="cell"
            :class="generateCellClass(cell)"
            :style="generateBorders(rowKey, columnKey)"
            @mousedown="event => startDrawing(cell, columnKey, rowKey, event.button)"
            @mouseover="event => draw(columnKey, rowKey)"
            />
        </div>
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

    .row {
        display: flex;

        .cell {
            --accent-border: #{$primary};
            width: 16px;
            height: 16px;
            background-color: $background-secondary;
            border-right: 1px solid grey;
            border-bottom: 1px solid grey;
            position: relative;
            box-sizing: content-box;

            &__colored {
                background-color: black;
            }

            &__excluded {
                &::after {
                    display: inline-block;
                    text-align: center;
                    vertical-align: middle;
                    content: 'X';
                    width: 16px;
                    height: 16px;
                }
            }
        }
    }
}
</style>