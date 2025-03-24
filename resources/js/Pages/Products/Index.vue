<script setup>
import { ref, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Sortable from "@/Components/Sortable.vue";
import CheckBox from "@/Components/CheckBox.vue";
import CheckAll from "@/Components/CheckAll.vue";
import BulkEdit from "./BulkEdit.vue";

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    query: {
        type: Object,
        default: () => ({
            search: "",
        }),
    },
});

const selectedProducts = computed(() => {
    return props.products.data
        .filter((product) => selectedIds.value.includes(product.id))
        .map((product) => ({ id: product.id, name: product.name }));
});

const deleteRow = (id) => {
    if (window.confirm("Are you sure?")) {
        router.delete(route("products.destroy", id), {
            preserveScroll: true,
        });
    }
};

const deleteSelected = () => {
    if (window.confirm("Are you sure?")) {
        router.delete(
            route("products.bulk.destroy", selectedIds.value.join(",")),
            {
                preserveScroll: true,
                onSuccess: () => {
                    selectedIds.value = [];
                },
            },
        );
    }
};

const handelSearch = (event) => {
    router.get(route("products.index"), {
        search: event.target.value,
    });
};

const selectedIds = ref([]);
const showModal = ref();
</script>

<template>
    <Head title="All Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Manage Products
                </h2>
                <Link
                    :href="route('products.create')"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700"
                    >New Product
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-end pb-6"
                >
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-5 h-5 text-gray-500"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </div>
                        <input
                            @keydown.enter="handelSearch"
                            :value="props.query.search"
                            type="text"
                            id="table-search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Search for items"
                        />
                    </div>
                </div>
                <!-- red -->
                <div class="space-x-3 mb-3">
                    <!-- Delete Button -->
                    <button
                        type="button"
                        class="px-3 py-2.5 text-sm font-medium text-center text-white rounded-md"
                        :class="{
                            ' bg-red-300 cursor-not-allowed':
                                selectedIds.length === 0,
                            'bg-red-600 hover:bg-red-700':
                                selectedIds.length > 0,
                        }"
                        :disabled="!selectedIds.length"
                        @click="deleteSelected"
                    >
                        Delete Selected
                    </button>
                    <!-- Edit Button  -->
                    <button
                        type="button"
                        class="px-3 py-2.5 text-sm font-medium text-center text-white rounded-md"
                        :class="{
                            ' bg-cyan-300 cursor-not-allowed':
                                selectedIds.length === 0,
                            'bg-cyan-600 hover:cyan-red-700':
                                selectedIds.length > 0,
                        }"
                        :disabled="!selectedIds.length"
                        @click="showModal = true"
                    >
                        Edit Selected
                    </button>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <table
                            class="w-full text-sm text-left rtl:text-right text-gray-500"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 border-b"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3" width="5">
                                        <CheckAll
                                            :rows="products.data"
                                            v-model="selectedIds"
                                        />
                                    </th>
                                    <th scope="col" class="px-6 py-3" width="5">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <Sortable
                                            name="name"
                                            label="Product Name"
                                        />
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <Sortable name="price" label="Price" />
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <Sortable
                                            name="weight"
                                            label="Weight"
                                        />
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr
                                    v-for="(product, index) in products.data"
                                    :key="product.id"
                                    class="bg-white border-b hover:bg-gray-50"
                                >
                                    <td
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        <CheckBox
                                            :value="product.id"
                                            v-model:checked="selectedIds"
                                        />
                                    </td>
                                    <td
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ products.meta.from + index }}
                                        <!-- {{ index + 1 }} -->
                                    </td>

                                    <td
                                        scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ product.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.category.name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.price_formatted }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ product.weight }}
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <Link
                                            :href="
                                                route(
                                                    'products.show',
                                                    product.id,
                                                )
                                            "
                                            class="font-medium text-gray-600 hover:underline"
                                        >
                                            Show
                                        </Link>
                                        <Link
                                            :href="
                                                route(
                                                    'products.edit',
                                                    product.id,
                                                )
                                            "
                                            class="font-medium text-blue-600 hover:underline"
                                            >Edit</Link
                                        >
                                        <a
                                            @click.prevent="
                                                deleteRow(product.id)
                                            "
                                            href="#"
                                            class="font-medium text-red-600 hover:underline"
                                            >Delete</a
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <Pagination :meta="products.meta" />
                    </div>
                </div>
            </div>
        </div>

        <BulkEdit
            :show="showModal"
            @click="showModal = true"
            @updated="selectedIds = []"
            :products="selectedProducts"
            :categories="categories"
        />
    </AuthenticatedLayout>
</template>
