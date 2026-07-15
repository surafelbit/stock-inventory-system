<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

defineProps({
    products: Array,
    categories: Array,
});

const form = useForm({
    name: "",
    sku: "",
    category_id: "",
    description: "",
    cost_price: "",
    price: "",
    stock: 0,
});

const submit = () => {
    form.post(route("products.store"), {
        onSuccess: () => form.reset(),
    });
};

const deleteProduct = (id) => {
    if (confirm("Are you sure you want to delete this product?")) {
        form.delete(route("products.destroy", id));
    }
};
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inventory Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow lg:col-span-1">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Add New Product
                        </h3>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Product Name</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >SKU (Stock Keeping Unit)</label
                                >
                                <input
                                    v-model="form.sku"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                    placeholder="e.g. ELEC-IPH15-01"
                                />
                                <p
                                    v-if="form.errors.sku"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.sku }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Category</label
                                >
                                <select
                                    v-model="form.category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                                    <option value="">Uncategorized</option>
                                    <option
                                        v-for="cat in categories"
                                        :key="cat.id"
                                        :value="cat.id"
                                    >
                                        {{ cat.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Cost Price ($)</label
                                    >
                                    <input
                                        v-model="form.cost_price"
                                        type="number"
                                        step="0.01"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required
                                    />
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Retail Price ($)</label
                                    >
                                    <input
                                        v-model="form.price"
                                        type="number"
                                        step="0.01"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Initial Stock</label
                                >
                                <input
                                    v-model="form.stock"
                                    type="number"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="2"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                            >
                                Save Product
                            </button>
                        </form>
                    </div>

                    <div
                        class="bg-white p-6 rounded-lg shadow lg:col-span-3 overflow-hidden"
                    >
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Stock Ledger
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            SKU
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Product Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Category
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Cost / Retail
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            In Stock
                                        </th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600"
                                        >
                                            {{ product.sku }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                        >
                                            {{ product.name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800"
                                            >
                                                {{
                                                    product.category
                                                        ? product.category.name
                                                        : "Uncategorized"
                                                }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            ${{ product.cost_price }} / ${{
                                                product.price
                                            }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm"
                                        >
                                            <span
                                                :class="
                                                    product.stock > 10
                                                        ? 'text-green-600'
                                                        : 'text-red-600 font-bold'
                                                "
                                            >
                                                {{ product.stock }} units
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <button
                                                @click="
                                                    deleteProduct(product.id)
                                                "
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="products.length === 0">
                                        <td
                                            colspan="6"
                                            class="px-6 py-4 text-center text-sm text-gray-500"
                                        >
                                            No products registered yet.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
