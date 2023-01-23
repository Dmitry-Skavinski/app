<template>
    <Teleport to="body">
        <div class="error-message">
            <slot></slot>
        </div>
    </Teleport>
</template>

<style lang="scss">
.error-message {
    position: fixed;
    bottom: 10px;
    right: 10px;
    color: $error;
    background-color: rgba($color: black, $alpha: 0.9);
    padding: 20px;
    border-radius: 5px;
    min-width: 200px;
}
</style>