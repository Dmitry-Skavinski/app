<script setup>
const { isOpen, close } = defineProps([ 'isOpen', 'close' ]);
</script>

<template>
    <Teleport to="body" v-if="isOpen">
        <div class="popup_background" @click="close"/>
        <div class="popup_content">
            <slot></slot>
        </div>
    </Teleport>
</template>

<style lang="scss">
.popup {
    &_background {
        height: 100vh;
        width: 100vw;
        background: rgba($color: $background-secondary, $alpha: 0.3);
        position: fixed;
        top: 0;
        left: 0;
    }

    &_content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
}
</style>
