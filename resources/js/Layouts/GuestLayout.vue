<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen w-full flex bg-surface-container-low text-on-surface overflow-hidden relative" style="font-family: 'Inter', sans-serif;">
        <!-- Left Side: Marketing and Visual (Desktop only) -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-16 bg-gradient-to-br from-primary via-primary-container to-secondary/80 text-white relative overflow-hidden">
            <!-- Ambient Floating Blobs for Visual Depth -->
            <div class="blob blob-a absolute -top-40 -left-40 w-[600px] h-[600px] bg-white/10 rounded-full blur-[120px] -z-10"></div>
            <div class="blob blob-b absolute top-1/3 right-10 w-[420px] h-[420px] bg-secondary-fixed/25 rounded-full blur-[110px] -z-10"></div>
            <div class="blob blob-c absolute -bottom-40 left-10 w-[500px] h-[500px] bg-white/15 rounded-full blur-[120px] -z-10"></div>

            <!-- Top Header Brand Link -->
            <div class="z-10">
                <Link href="/" class="inline-flex items-center gap-3.5 group">
                    <ApplicationLogo class="h-10 w-10 fill-current text-white transform group-hover:scale-105 transition-transform" />
                    <span class="font-headline-md text-headline-md font-bold text-white tracking-tight">Invenio Pro</span>
                </Link>
            </div>

            <!-- Content Area: Hero Copy & Floating Dashboard Mockup -->
            <div class="z-10 my-auto flex flex-col justify-center max-w-xl">
                <h1 class="font-headline-lg text-[40px] sm:text-[48px] leading-[1.1] font-extrabold text-white mb-6 tracking-tight">
                    Inventory Intelligence, <br/>
                    <span class="text-secondary-fixed">Redefined.</span>
                </h1>
                <p class="font-body-lg text-[16px] sm:text-[18px] leading-relaxed text-white/80 mb-10">
                    The high-performance platform for supply chain masters. Orchestrate global stock, optimize workforce deployment, and unify multi-channel sales in one single, high-fidelity source of truth.
                </p>

                <!-- Floating Dashboard Mockup -->
                <div class="float-slow p-2 rounded-2xl shadow-[0_25px_60px_rgba(0,0,0,0.25)] border border-white/15 backdrop-blur-md" style="background: rgba(255,255,255,0.08);">
                    <img
                        alt="Modern SaaS inventory management dashboard preview"
                        class="w-full h-auto rounded-xl object-cover"
                        src="https://lh3.googleusercontent.com/aida/AP1WRLvGdSQdwzqY3MpY7tAnUwkKF0IqWIUmymAkUrWat8nqpkBmTejFApA6Dwir8atON4E_fb2Lm7VIJyy-9ZDqzP9qg6Rf6a-pxF5POzGnFPKue1qvGpp6ebwVVHDCpdJapdbNiv6DXKysBXS5mI8LMhnzdx2tsYpcRYJDnr3mmumXEzlD_uCG0jTknjPAmvK0ux3M4SBDSYFxvfU4Dfc8sV-22LVqaNdmuyZLP0Dupp-WfSihalVJZEeCgcg"
                        onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                    />
                </div>
            </div>

            <!-- Footer area -->
            <div class="z-10 text-white/60 font-body-md text-[13px] flex items-center justify-between">
                <span>© 2026 Invenio Pro. All rights reserved.</span>
                <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">verified_user</span> Enterprise Grade Security</span>
            </div>
        </div>

        <!-- Right Side: Forms Workspace -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 md:p-16 relative bg-surface-container-low">
            <!-- Background Ambient Light Blobs -->
            <div class="blob blob-d absolute -top-40 -right-40 w-[500px] h-[500px] bg-primary/10 rounded-full blur-[120px] -z-10"></div>
            <div class="blob blob-e absolute -bottom-40 -left-40 w-[500px] h-[500px] bg-secondary/15 rounded-full blur-[120px] -z-10"></div>

            <div class="w-full flex flex-col items-center justify-center">
                <!-- Mobile brand logo (visible only on mobile/tablet) -->
                <div class="lg:hidden mb-8">
                    <Link href="/" class="inline-flex items-center gap-3">
                        <ApplicationLogo class="h-10 w-10 fill-current text-primary" />
                        <span class="font-headline-md text-headline-md font-bold text-on-surface tracking-tight">Invenio Pro</span>
                    </Link>
                </div>

                <!-- Glassmorphism Form Container -->
                <div class="w-full max-w-[460px] bg-white/70 backdrop-blur-xl border border-outline-variant/30 px-8 py-10 shadow-2xl rounded-3xl z-10 transition-all duration-300 hover:shadow-primary/5">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');

/* Floating blobs */
.blob { animation: floatBlob 12s ease-in-out infinite; }
.blob-a { animation-duration: 14s; }
.blob-b { animation-duration: 10s; animation-delay: -3s; }
.blob-c { animation-duration: 16s; animation-delay: -6s; }
.blob-d { animation-duration: 11s; }
.blob-e { animation-duration: 13s; animation-delay: -4s; }

@keyframes floatBlob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(25px, -15px) scale(1.06); }
    66% { transform: translate(-15px, 20px) scale(0.96); }
}

/* Gentle floating card animation */
.float-slow { animation: floatSlow 6s ease-in-out infinite; }
@keyframes floatSlow {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

@media (prefers-reduced-motion: reduce) {
    .blob, .float-slow { animation: none !important; }
}
</style>
