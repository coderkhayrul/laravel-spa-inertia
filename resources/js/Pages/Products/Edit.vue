<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import ProductForm from "./ProductForm.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    ...props.product,
    category_id: props.product.category.id,
});

// const form = useForm({
//     name: props.product.name,
//     brand: props.product.brand,
//     category_id: "",
//     price: props.product.price,
//     weight: props.product.weight,
//     description: props.product.description,
// });

const update = () => {
    form.put(route("products.update", form.id), {
        onSuccess: () => form.reset(),
    });
};
const deleteRow = (id) => {
    if (window.confirm("Are you sure?")) {
        router.delete(route("products.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Edit Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Product
                </h2>
                <Link
                    :href="route('products.index')"
                    class="flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700"
                    >Manage Product
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-center">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <ProductForm
                            :form="form"
                            :categories="categories"
                            @submit="update"
                        >
                            <div class="flex items-center justify-between">
                                <div class="space-x-2">
                                    <button
                                        type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                    >
                                        Update
                                    </button>
                                    <Link
                                        :href="route('products.index')"
                                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5"
                                    >
                                        Cancel
                                    </Link>
                                    <a
                                        @click.prevent="deleteRow(product.id)"
                                        href="#"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                        >Delete</a
                                    >
                                </div>
                            </div>
                        </ProductForm>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
