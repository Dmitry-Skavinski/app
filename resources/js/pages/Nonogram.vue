<script setup>
import axios from 'axios';
import { reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import Canvas from '../components/Canvas.vue';
import nonograms from '../stores/nonograms';
import user from '../stores/user';

const route = useRoute();
const task = reactive({});
const state = reactive([]);
 
(async function() {
    if (nonograms[route.params.id]) {
        Object.assign(task, nonograms[route.params.id]);
    } else {
        const { data } = await axios.get(`/api/nonogram/${route.params.id}`);
        Object.assign(task, data);
    }
    try {
        const { data } = await axios.get(`/api/nonogram/progress/${route.params.id}`);
        Object.assign(state, data.data);
    } catch {
        Object.assign(state, new Array(task.height).fill(0).map(el => new Array(task.width).fill(0)));
    }
})();

const saveProgress = async () => {
    axios.put(`/api/nonogram/progress/${route.params.id}`, {data: state});
}

const scale = ref(1);

const setScale = (event) => {
    scale.value = event.target.value;
}

const mode = ref('lines');
const toggleMode = () => {
    mode.value = mode.value === 'default' ? 'lines' : 'default';
}
</script>
<template>
    <main class="route-nonogram"  :style="{'--scale': scale}">
        <div class="controls">
            <div>
                Mode: 
                <button @click="toggleMode">{{ mode }}</button>
            </div>
            <div>
                Scale:
                <input type="range" min="0.5" max="10" @input="setScale" :value="scale" step="0.1"/>
            </div>
            <button v-if="user.name" @click="saveProgress">save</button>
        </div>
        <div class="nonogram__wrapper">
            <div class="task task__top">
                <div v-for="column in task.task?.top" class="task__column">
                    <div v-for="cell in column" class="task__cell">{{ cell }}</div>
                </div>
            </div>
            <div class="task task__left">
                <div v-for="row in task.task?.left" class="task__row">
                    <div v-for="cell in row" class="task__cell">{{ cell }}</div>
                </div>
            </div>
            <Canvas v-if="task.width" :mode="mode" :height="task.height" :width="task.width" :scale="scale" :state="state"/>
        </div>
    </main>
</template>

<style lang="scss">
.route-nonogram {
    width: 100%;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding-block: 20px;

    .controls {
        > div {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        input[type=range] {
            height: 32px;
        }
    }
}

.nonogram__wrapper {
    display: grid;
    grid-template-areas:
    '0 top'
    'left canvas';
    grid-template-columns: min-content min-content;
    grid-template-rows: min-content min-content;
    max-width: 100%;
    width: min-content;
    overflow: scroll;
    align-self: center;

    .task {
        pointer-events: none;

        &__top {
            grid-area: top;
            display: flex;
            width: max-content;
            height: max-content;
            border-left: 2px solid;
        }

        &__cell {
            width: calc($cell-size * var(--scale));
            height: calc($cell-size * var(--scale));
            box-sizing: content-box;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: calc(14px * var(--scale));
        }

        &__column {
            min-width: calc($cell-size * var(--scale));
            min-height: calc($cell-size * var(--scale));
            border-right: 2px solid;
            box-sizing: content-box;
            display: flex;
            flex-direction: column;
            justify-content: end;
        }

        &__row {
            min-width: calc($cell-size * var(--scale));
            min-height: calc($cell-size * var(--scale));
            border-bottom: 2px solid;
            box-sizing: content-box;
            display: flex;
            justify-content: end;
        }

        &__left {
            grid-area: left;
            width: max-content;
            height: max-content;
            border-top: 2px solid;
        }
    }

    .canvas {
        grid-area: canvas;
    }
}
</style>
