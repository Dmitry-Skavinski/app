<script setup>
import { ref, reactive } from 'vue';
import Canvas from '../components/Canvas.vue';
import Popup from '../components/Popup.vue';
import InputText from '../components/InputText.vue';
import user from '../stores/user';
import axios from 'axios';

const nonogram = reactive({
    name: '',
    width: '',
    height: '',
    error: '',
    state: Array(0)
})

const validateNonogram = () => {
    const { name, width, height } = nonogram;
    let message = '';

    switch (false) {
        case name.length >= 3: message = 'name is too short';
        break;
        case +width > 4 && +height > 4: message = 'invalid size';
    }

    return message ? [false, message] : [true];
}

const createNonogram = (height, width) => {
    if (validateNonogram()[0]) {
        const initialState =  new Array(+height).fill(0).map(el => new Array(+width).fill(0));
        nonogram.state = initialState;
        popup.value = false;
    } else {
        nonogram.error = validateNonogram()[1];
    }
}

const saveNonogram = async (nonogram) => {
    axios.post('/api/nonogram/save', nonogram);
}

const popup = ref(true);

const mode = ref('default');

const toggleMode = () => {
    mode.value = mode.value === 'default' ? 'lines' : 'default';
}

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
        <div class="canvas_wrapper" v-if="!popup">
            <Canvas :height="+nonogram.height" :width="+nonogram.width" :scale="scale" :mode="mode" :state="nonogram.state"/>  
        </div>
        <div class="canvas_controls" v-if="!popup">
            <div>
                Scale: {{ scale }}
                <input type="range" min="0.5" max="10" @input="resize" :value="scale" step="0.1"/>
            </div>
            <div>
                Mode: {{ mode }}
                <button @click="toggleMode">toggle mode</button>
            </div>
            <button>save</button>
        </div>
    </main>
    <Popup :isOpen="popup">
        <form class="nonogram-creation">
            <InputText name="name" v-model="nonogram.name"/>
            <InputText name="width" v-model="nonogram.width"/>
            <InputText name="height" v-model="nonogram.height"/>
            <Transition name="error">
                <p class="error" v-if="nonogram.error">{{ nonogram.error }}</p>
            </Transition>
            <button @click.prevent="() => createNonogram(nonogram.height, nonogram.width)" class="button-secondary">create</button>
        </form>
    </Popup>
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
            width: 100%;
            grid-area: controls;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-around;
            height: 60px;

            > div {
                display: flex;
                flex-direction: column;
                height: 100%;
                flex: 1;
            }

            > button {
                width: 200px;
                flex: 1;
            }

            input[type="range"] {
                width: 100px;
                margin: 0;
            }
        }
    }
}

.nonogram-creation {
    .error {
        width: 200px;
        height: 30px;
        margin: 0;

        &-enter {
            &-active {
                transition: all 0.3s ease;
            }

            &-from {
                height: 0px;
            }

            &-to {
                height: 30px;
            }
        }
    }

    .button-secondary {
        width: 200px;
        color: $background-secondary;
    }
}
</style>
