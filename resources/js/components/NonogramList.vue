<script setup>
import axios from 'axios';
import { useRoute } from 'vue-router';
import nonograms from '../stores/nonograms';
const { source } = defineProps(['source'])

const route = useRoute();

(async function() {
        const { data } = await axios.get(`${window.location.origin + '/' + source}?p=${route.query.p || 1}`);
        nonograms.data = data.data;
})();
</script>

<template>
    <div class="nonogram_list">
        <RouterLink v-for="item in nonograms.data" class="nonogram__item" :to="`/nonogram/${item.id}`">
            <div class="nonogram__item__size">
                {{ item.height }} x {{ item.width }}
            </div>
            <div class="nonogram__item__description">
                <h2 class="nonogram__item__name">{{ item.name }}</h2>
                by <RouterLink :to="`/author/${item.author_id}`">{{  item.author.name }}</RouterLink>
            </div>
        </RouterLink>
    </div>
</template>

<style lang="scss">
.nonogram_list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.nonogram__item {
    display: flex;
    gap: 20px;
    border: 2px solid $accent;

    &:hover {
        color: $primary
    }

    &__name {
        margin: 0;
    }

    &__size {
        height: 64px;
        width: 64px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: $accent;
        color: white;
        border: 2px solid $accent;
        border-bottom-right-radius: 50%;
    }
}
</style>
