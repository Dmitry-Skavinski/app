<script setup>
import NonogramList from '../components/NonogramList.vue';
</script>
<template>
    <main class="route-home">
        <NonogramList source="api/nonogram/list"/>
    </main>
</template>
