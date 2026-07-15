<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

// Receive the categories list passed from the Laravel controller
defineProps({
    categories: Array,
});

// Setup the Inertia form state
const form = useForm({
    name: "",
    description: "",
});

const submit = () => {
    form.post(route("categories.store"), {
        onSuccess: () => form.reset(),
    });
};

const deleteCategory = (id) => {
    if (confirm("Are you sure you want to delete this category?")) {
        form.delete(route("categories.destroy", id));
    }
};
</script>

<template>
    <Head title="Categories" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product Categories
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow sm:rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Add New Category
                        </h3>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Category Name</label
                                >
                                <input
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required
                                />
                                <p
                                    v-if="form.errors.name"
                                    class="text-red-500 text-xs mt-1"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                    >Description</label
                                >
                                <textarea
                                    v-model="form.description"
                                    rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                ></textarea>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Save Category
                            </button>
                        </form>
                    </div>

                    <div
                        class="bg-white p-6 rounded-lg shadow sm:rounded-lg md:col-span-2"
                    >
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Existing Categories
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Name
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Description
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
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                                        >
                                            {{ category.name }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                                        >
                                            {{ category.description || "N/A" }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                        >
                                            <button
                                                @click="
                                                    deleteCategory(category.id)
                                                "
                                                class="text-red-600 hover:text-red-900"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="categories.length === 0">
                                        <td
                                            colspan="3"
                                            class="px-6 py-4 text-center text-sm text-gray-500"
                                        >
                                            No categories found. Start by adding
                                            one!
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
