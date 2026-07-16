<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-background text-on-background min-h-screen flex flex-col" style="font-family: 'Inter', sans-serif;">
        <!-- Top Navigation -->
        <nav class="bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop h-16 w-full max-w-container-max mx-auto z-50">
            <Link href="/" class="font-headline-md text-headline-md font-bold text-primary" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Invenio Pro
            </Link>
            <a href="#" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-200">Help Center</a>
        </nav>

        <!-- Main Content split card -->
        <main class="flex-grow flex items-center justify-center py-stack-lg px-margin-mobile md:px-margin-desktop">
            <div class="max-w-[1200px] w-full grid grid-cols-1 lg:grid-cols-2 border border-outline-variant/30 overflow-hidden rounded-xl bg-white shadow-xl">
                <!-- Left Side: Visual/Branding -->
                <div class="hidden lg:block relative bg-surface-container overflow-hidden">
                    <div class="absolute inset-0 opacity-40">
                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCLHQh7X-iDvjMNtt_C5LyuiHZqiH9oZujqOwo1eYrnPf7GR8_oxUVzz5ZpSlabPKKiL2eOaD8CHYXWaLAo47AAmDVeY-2taxtNn9LA9-i7cG1hi9aT1C1mZRTOC6GCKtQfr8Ek2akfpEICjY0O7DIDv7CEwqiPO_42YTgimTn0nDRDMjwOAF_fQsTlPt3MdndP_pC87wsD3dcXx8R_-0-EAKdhOVLbi1DpVtyJcG8LcUJQ8wGL_3OQ')"></div>
                    </div>
                    <div class="relative z-10 h-full p-12 flex flex-col justify-between">
                        <div>
                            <h1 class="font-headline-lg text-headline-lg text-on-surface mb-stack-md leading-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Institutional Precision.
                            </h1>
                            <ul class="space-y-stack-sm font-body-lg text-body-lg text-on-surface-variant">
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Real-time clarity
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Predictive intelligence
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                    Global supply chain scale
                                </li>
                            </ul>
                        </div>
                        <div class="space-y-stack-md">
                            <div class="flex items-center gap-stack-sm text-primary">
                                <span class="material-symbols-outlined text-[24px]">verified</span>
                                <span class="font-label-md text-label-md">ISO 27001 Certified Security</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Forms Workspace -->
                <div class="p-8 md:p-12 bg-white flex flex-col justify-center">
                    <slot />
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-surface-container-lowest border-t border-outline-variant w-full">
            <div class="flex flex-col md:flex-row justify-between items-center py-stack-lg px-margin-desktop w-full max-w-container-max mx-auto">
                <div class="font-label-md text-label-md text-on-surface-variant mb-stack-md md:mb-0">
                    © 2026 Invenio Pro. High-End Inventory Logistics.
                </div>
                <div class="flex gap-stack-lg">
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-150" href="#">Privacy Policy</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-150" href="#">Terms of Service</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-150" href="#">Security</a>
                    <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors duration-150" href="#">Contact Support</a>
                </div>
            </div>
        </footer>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');
</style>
