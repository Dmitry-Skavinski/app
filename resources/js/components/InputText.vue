<script setup>
const { modelValue, type, placeholder, name} = defineProps(['modelValue', 'type', 'placeholder', 'name']);
</script>

<template>
    <div class="input-text">
        <input v-model="modelValue" @input="$emit('update:modelValue', $event.target.value)" :type="type" :placeholder="placeholder || name"/>
        <span v-if="name">{{ name }}</span>
    </div>
</template>

<style lang="scss" scoped>
.input-text {
    display: block;
    position: relative;
    font-size: 16px;

    input {
        outline: 2px $primary solid;
        border-radius: 0;
        border: 0;
        width: 200px;
        padding-block: 0;
        line-height: 20px;
        caret-color: $accent;
        padding-inline: 4px;

        &::placeholder {
            color: $primary;
        }

        &:focus {
            outline: 2px $accent solid;

            &::placeholder {
                color: $accent;
            }

            ~ span {
                display: inline;
                position: absolute;
                right: 100%;
                padding-inline: 4px;
                line-height: 20px;
                background-color: $accent;
                color: $background-secondary;
                outline: $accent 2px solid;
            }
        }
    }

    span {
        display: none;
    }
}
</style>