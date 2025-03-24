<script setup>
import CheckBox from "@/Components/CheckBox.vue";
import { computed } from "vue";

const props = defineProps({
    rows: {
        type: Array,
        required: true,
    },
    modelValue: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["update:modelValue"]);

const proxyChecked = computed({
    get() {
        return props.modelValue.length === props.rows.length;
    },

    set(val) {
        const checked = [];
        if (val) {
            props.rows.forEach((row) => {
                checked.push(row.id);
            });
        }
        emit("update:modelValue", checked);
    },
});
</script>

<template>
    <CheckBox v-model:checked="proxyChecked" />
</template>
