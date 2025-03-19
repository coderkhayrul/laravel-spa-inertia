<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    products: {
        type: Object,
        required: true,
    },
});

const deleteRow = (id) => {
    if (window.confirm("Are you sure?")) {
        router.delete(route("products.destroy", id), {
            preserveScroll: true,
        });
    }
};
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

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">
                                        Weight
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
    </AuthenticatedLayout>
</template>
