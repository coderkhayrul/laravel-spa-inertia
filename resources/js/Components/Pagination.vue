<script setup>
defineProps({
    meta: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <nav
        class="flex items-center flex-column flex-wrap md:flex-row justify-between py-2 px-4"
        aria-label="Table navigation"
    >
        <span
            class="text-sm font-normal text-gray-700 mb-4 md:mb-0 block w-full md:inline md:w-auto"
            >Showing
            <span class="font-semibold text-gray-700">1-10</span>
            of
            <span class="font-semibold text-gray-700">1000</span></span
        >
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700"
                    >Previous</a
                >
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700"
                    >1</a
                >
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700"
                    >2</a
                >
            </li>
            <li>
                <a
                    href="#"
                    aria-current="page"
                    class="flex items-center justify-center px-3 h-8 text-blue-600 hover:text-blue-700"
                    >3</a
                >
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700"
                    >4</a
                >
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 hover:text-gray-700"
                    >5</a
                >
            </li>
            <li>
                <a
                    href="#"
                    class="flex items-center justify-center px-3 h-8 leading-tight text-stone-400 hover:text-stone-400 cursor-not-allowed"
                    >Next</a
                >
            </li>
        </ul>
    </nav>
</template>
