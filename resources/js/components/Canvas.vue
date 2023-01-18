<script setup>
import { reactive } from 'vue';
const { mode, height, width, scale, state } = defineProps(['mode', 'height', 'width', 'scale', 'state']);

const initialPath = {
    toState: 1,
    initialX: undefined,
    initialY: undefined,
    isVertical: undefined,
    initialState: undefined,
    isActive: false
};

const path = reactive(initialPath);

const startDrawing = (cell, x, y, button) => {
    path.initialX = x;
    path.initialY = y;
    path.isActive = true;

    path.initialState = Array(height).fill(0).map((el, key) => [...state[key]]);

    switch (button) {
        case 0: path.toState = cell === 1 ? 0 : 1;
        break;
        case 1: path.toState = cell === 3 ? 0 : 3;
        break;
        case 2: path.toState = cell === 2 ? 0 : 2;
        break;
    }

    draw(x, y);
}

const stopDrawing = () => {
    path.isActive = false;
}

const drawLine = (x1, y1, x2, y2, isVertical) => {
    const { min, max } = Math;
    if (isVertical) {
        for ( let i = min(y1, y2); i <= max(y1, y2); i++ ) {
            state[i][x1] = path.toState;
        }
    } else {
        for ( let i = min(x1, x2); i <= max(x1, x2); i++ ) {
            state[y1][i] = path.toState;
        }
    }
}

const draw = (x, y, activeMode = 'default') => {
    if (!path.isActive) return;
    switch (activeMode) {
        case 'default':
            state[y][x] = path.toState;
            return;
        case 'lines':
            if (x != path.initialX || y != path.initialY) {
                const xDistance = Math.abs(x - path.initialX);
                const yDistance = Math.abs(y - path.initialY);
                const isVertical = yDistance > xDistance;

                if (yDistance == 1 || xDistance == 1) {
                    path.isVertical = isVertical;
                }

                if (path.isVertical === isVertical) {
                    drawLine(path.initialX, path.initialY, x, y, isVertical);
                } else {
                    for (let key in state) {
                        state[key] = [... path.initialState[key]]
                    }
                }

            } else {
                state[y][x] = path.toState;
            }
            return;
    }
    
}

const generateBorders = (row, column) => {
    const styles = {};
    if (!((row + 1) % 5)) {
        styles['border-bottom'] = '2px solid var(--accent-border)'
    }
    if (!(row % 5)) {
        styles['border-top'] = 'none'
    }
    if (!((column + 1) % 5)) {
        styles['border-right'] = '2px solid var(--accent-border)'
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
        default: return 'cell__withText';
    }
}

const generateCellContent = (cellValue) => {
    switch (cellValue) {
        case 2: return 'x';
        case 3: return '·';
        default: return '';
    }
}
</script>

<template>
    <div class="canvas" @mouseup="stopDrawing" @mouseleave="stopDrawing" @contextmenu.prevent="" :style="{'--scale': scale}">
        <div v-for="(row, rowKey) in state" class="row">
            <div
            v-for="(cell, columnKey) in row"
            class="cell"
            :class="generateCellClass(cell)"
            :style="generateBorders(rowKey, columnKey)"
            @mousedown="event => startDrawing(cell, columnKey, rowKey, event.button)"
            @mouseover="() => draw(columnKey, rowKey, mode)"
            >
            {{ generateCellContent(cell) }}
        </div>
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
    border: 2px solid $primary;
    user-select: none;

    .row {
        display: flex;

        .cell {
            --accent-border: #{$primary};
            width: calc(16px * var(--scale));
            height: calc(16px * var(--scale));
            background-color: $background-secondary;
            border-right: 2px solid grey;
            border-bottom: 2px solid grey;
            box-sizing: content-box;
            display: flex;

            &__colored {
                background-color: black;
            }

            &__withText {
                font-size: calc(14px * var(--scale));
                justify-content: center;
                font-weight: bolder;
            }
        }
    }
}
</style>
