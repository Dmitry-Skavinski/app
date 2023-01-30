<script setup>
import NonogramList from '../components/NonogramList.vue';
import { useRoute } from 'vue-router';
const route = useRoute();
</script>
<template>
    <main class="route-author">
        <NonogramList :source="`api/nonogram/list/${route.params.id}`"/>
    </main>
</template>
