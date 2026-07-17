<script setup>
import { ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-surface-container-low text-on-surface" style="font-family: 'Inter', sans-serif;">
            <nav class="sticky top-0 z-50 border-b border-outline-variant/30 bg-surface/85 backdrop-blur-lg">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center">
                        <div class="flex items-center h-full">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center me-8">
                                <Link :href="route('dashboard')" class="font-headline-md text-headline-md font-extrabold text-on-surface tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    Invenio <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-surface-tint">Pro</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden sm:flex space-x-1 h-full items-center">
                                <Link
                                    :href="route('dashboard')"
                                    class="relative font-body-md text-body-md flex items-center h-full px-4 border-b-2 transition-all duration-200"
                                    :class="route().current('dashboard') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:border-outline-variant'"
                                >
                                    Dashboard
                                </Link>
                                <Link
                                    :href="route('products.index')"
                                    class="relative font-body-md text-body-md flex items-center h-full px-4 border-b-2 transition-all duration-200"
                                    :class="route().current('products.index') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:border-outline-variant'"
                                >
                                    Products
                                </Link>
                                <Link
                                    :href="route('categories.index')"
                                    class="relative font-body-md text-body-md flex items-center h-full px-4 border-b-2 transition-all duration-200"
                                    :class="route().current('categories.index') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:border-outline-variant'"
                                >
                                    Categories
                                </Link>
                                <Link
                                    :href="route('suppliers.index')"
                                    class="relative font-body-md text-body-md flex items-center h-full px-4 border-b-2 transition-all duration-200"
                                    :class="route().current('suppliers.index') ? 'border-primary text-primary font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:border-outline-variant'"
                                >
                                    Suppliers
                                </Link>
                            </div>
                        </div>

                        <!-- Right navbar elements -->
                        <div class="hidden sm:flex sm:items-center sm:gap-4">
                            <!-- Workspace Badge -->
                            <div class="flex items-center">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold bg-secondary/10 text-secondary border border-secondary/20 uppercase tracking-wider"
                                >
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-secondary opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-secondary"></span>
                                    </span>
                                    {{ $page.props.auth.company.name }}
                                </span>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-lg border border-outline-variant/30 bg-surface-container-high/60 px-4 py-2 text-sm font-medium leading-4 text-on-surface transition duration-150 ease-in-out hover:bg-surface-container-highest hover:text-primary focus:outline-none backdrop-blur-md"
                                            >
                                                {{ $page.props.auth.user.name }}
                                                <span class="material-symbols-outlined text-sm ms-1.5">keyboard_arrow_down</span>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-lg p-2 text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition duration-150 ease-in-out border border-transparent hover:border-outline-variant/30"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden border-t border-outline-variant/30 bg-surface"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <Link
                            :href="route('dashboard')"
                            class="block w-full ps-4 pe-4 py-2.5 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out"
                            :class="route().current('dashboard') ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low'"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('products.index')"
                            class="block w-full ps-4 pe-4 py-2.5 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out"
                            :class="route().current('products.index') ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low'"
                        >
                            Products
                        </Link>
                        <Link
                            :href="route('categories.index')"
                            class="block w-full ps-4 pe-4 py-2.5 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out"
                            :class="route().current('categories.index') ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low'"
                        >
                            Categories
                        </Link>
                        <Link
                            :href="route('suppliers.index')"
                            class="block w-full ps-4 pe-4 py-2.5 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out"
                            :class="route().current('suppliers.index') ? 'border-primary text-primary bg-primary/5 font-bold' : 'border-transparent text-on-surface-variant hover:text-primary hover:bg-surface-container-low'"
                        >
                            Suppliers
                        </Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-outline-variant/30 pb-4 pt-4">
                        <div class="px-4 mb-3">
                            <div class="text-base font-bold text-on-surface">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm text-on-surface-variant">
                                {{ $page.props.auth.user.email }}
                            </div>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-secondary/10 text-secondary border border-secondary/20 uppercase tracking-wider"
                                >
                                    Workspace: {{ $page.props.auth.company.name }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <Link
                                :href="route('profile.edit')"
                                class="block w-full ps-4 pe-4 py-2 text-start text-sm font-medium text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition duration-150"
                            >
                                Profile
                            </Link>
                            <Link
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="block w-full ps-4 pe-4 py-2 text-start text-sm font-medium text-on-surface-variant hover:text-error hover:bg-error-container/20 transition duration-150"
                            >
                                Log Out
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-surface/50 border-b border-outline-variant/20" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="relative">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');

.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
    vertical-align: middle;
}
</style>
