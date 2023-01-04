import { reactive } from "vue";

export const user = reactive(window.user || {});

export default user;