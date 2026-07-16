<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
});

onMounted(() => {
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-8');
            }
        });
    }, observerOptions);

    document.querySelectorAll('section > div').forEach(el => {
        el.classList.add('transition-all', 'duration-1000', 'opacity-0', 'translate-y-8');
        observer.observe(el);
    });
});
</script>

<template>
    <Head title="Invenio Pro | Inventory Intelligence, Redefined" />

    <div class="bg-surface-container-low text-on-surface" style="font-family: 'Inter', sans-serif; selection-background: #e2dfff;">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>

        <!-- Top Navigation -->
        <nav class="w-full top-0 sticky z-50 bg-surface-container/90 backdrop-blur-lg border-b border-outline-variant/30 h-20">
            <div class="flex justify-between items-center max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop h-full">
                <div class="flex items-center gap-stack-lg">
                    <span class="font-headline-md text-headline-md font-bold text-on-surface">Invenio Pro</span>
                    <div class="hidden md:flex gap-stack-lg ml-stack-lg">
                        <a class="font-body-md text-body-md text-on-surface font-bold border-b-2 border-primary pb-1" href="#">Product</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors duration-200" href="#">Solutions</a>
                        <a class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors duration-200" href="#">Pricing</a>
                    </div>
                </div>
                <div class="flex items-center gap-stack-md">
                    <Link v-if="canLogin && $page.props.auth?.user" :href="route('dashboard')" class="hidden md:block font-label-md text-label-md text-on-surface px-4 py-2 hover:bg-surface-variant rounded transition-all">Dashboard</Link>
                    <template v-else-if="canLogin">
                        <Link :href="route('login')" class="hidden md:block font-label-md text-label-md text-on-surface px-4 py-2 hover:bg-surface-variant rounded transition-all">Sign In</Link>
                        <Link v-if="canRegister" :href="route('register')" class="bg-primary text-on-primary px-6 py-2.5 rounded font-label-md text-label-md active:scale-95 transition-transform shadow-md hover:bg-primary-container" style="box-shadow: inset 0 1px 0 0 rgba(255,255,255,0.2);">Book a Demo</Link>
                    </template>
                    <button v-else class="bg-primary text-on-primary px-6 py-2.5 rounded font-label-md text-label-md active:scale-95 transition-transform shadow-md hover:bg-primary-container" style="box-shadow: inset 0 1px 0 0 rgba(255,255,255,0.2);">Book a Demo</button>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-24 pb-48 overflow-hidden bg-gradient-to-br from-surface-container via-surface-container-low to-primary/15" style="clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);">
            <div class="absolute top-0 right-0 w-3/4 h-full bg-gradient-to-l from-primary/15 to-transparent -z-10 skew-x-12 transform translate-x-1/4"></div>
            <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-primary/15 rounded-full blur-[120px] -z-10"></div>
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="text-left z-10">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-primary font-label-md text-label-md mb-8" style="background: rgba(211,228,254,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.08);">
                            <span class="material-symbols-outlined" style="font-size: 16px;">verified</span>
                            Institutional Inventory Management
                        </div>
                        <h1 class="font-headline-lg text-[64px] lg:text-[84px] leading-[1.05] text-on-surface font-extrabold mb-8 tracking-tight">
                            Inventory Intelligence, <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Redefined.</span>
                        </h1>
                        <p class="font-body-lg text-[20px] leading-relaxed text-on-surface-variant max-w-xl mb-12">
                            The high-performance platform for supply chain masters. Orchestrate global stock, optimize workforce deployment, and unify multi-channel sales in one single, high-fidelity source of truth.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <Link v-if="canRegister" :href="route('register')" class="bg-primary text-on-primary px-8 py-4 rounded-lg font-headline-sm text-headline-sm flex items-center justify-center gap-2 hover:bg-primary-container transition-all shadow-lg hover:shadow-primary/20">
                                Start Free Trial <span class="material-symbols-outlined">arrow_forward</span>
                            </Link>
                            <button v-else class="bg-primary text-on-primary px-8 py-4 rounded-lg font-headline-sm text-headline-sm flex items-center justify-center gap-2 hover:bg-primary-container transition-all shadow-lg hover:shadow-primary/20">
                                Start Free Trial <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                            <button class="text-on-surface px-8 py-4 rounded-lg font-headline-sm text-headline-sm flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all" style="background: rgba(211,228,254,0.6); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.08);">
                                Watch Product Tour
                            </button>
                        </div>
                    </div>
                    <!-- Hero Mockup -->
                    <div class="relative z-10 h-full flex items-center lg:-mr-32 mt-12 lg:mt-0">
                        <div class="absolute inset-0 bg-gradient-to-tr from-secondary/25 to-primary/25 rounded-[2rem] blur-3xl opacity-60 transform rotate-6 scale-105 -z-10"></div>
                        <div class="p-2 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.18)] border border-outline-variant/30 transform -rotate-2 hover:rotate-0 transition-transform duration-500" style="background: rgba(211,228,254,0.55); backdrop-filter: blur(20px);">
                            <img
                                alt="Modern SaaS inventory management dashboard"
                                class="w-full h-auto rounded-xl object-cover"
                                src="https://lh3.googleusercontent.com/aida/AP1WRLvGdSQdwzqY3MpY7tAnUwkKF0IqWIUmymAkUrWat8nqpkBmTejFApA6Dwir8atON4E_fb2Lm7VIJyy-9ZDqzP9qg6Rf6a-pxF5POzGnFPKue1qvGpp6ebwVVHDCpdJapdbNiv6DXKysBXS5mI8LMhnzdx2tsYpcRYJDnr3mmumXEzlD_uCG0jTknjPAmvK0ux3M4SBDSYFxvfU4Dfc8sV-22LVqaNdmuyZLP0Dupp-WfSihalVJZEeCgcg"
                                onerror="this.src='https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=800&q=80'"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Trusted By Bar -->
        <section class="py-16 -mt-16 bg-surface-container relative z-20 shadow-sm border-y border-outline-variant/30">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <p class="font-label-md text-label-md text-center text-outline mb-8 uppercase tracking-[0.2em]">Trusted by Global Enterprises</p>
                <div class="flex flex-wrap justify-center items-center gap-16 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
                    <span class="font-headline-sm font-bold text-on-surface">LOGISTX</span>
                    <span class="font-headline-sm font-bold text-on-surface">SUPPLYCORP</span>
                    <span class="font-headline-sm font-bold text-on-surface">MERIDIAN</span>
                    <span class="font-headline-sm font-bold text-on-surface">QUANTUM</span>
                    <span class="font-headline-sm font-bold text-on-surface">VERTEX</span>
                </div>
            </div>
        </section>

        <!-- Key Features -->
        <section class="py-32 bg-surface-container-low relative overflow-hidden">
            <div class="absolute right-0 top-1/4 w-[500px] h-[500px] bg-secondary/15 rounded-full blur-[100px] -z-10"></div>
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="mb-16">
                    <h2 class="font-headline-lg text-[48px] text-on-surface mb-4 font-extrabold">Next-Gen Capabilities</h2>
                    <p class="font-body-lg text-on-surface-variant max-w-2xl">Engineered for absolute control and uncompromised visibility across your entire supply chain network.</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Feature 1 (Hero sized) -->
                    <div class="lg:col-span-2 p-12 rounded-3xl border border-outline-variant/40 hover:border-primary/40 transition-all group hover:shadow-[0_0_40px_rgba(79,70,229,0.08)] relative overflow-hidden flex flex-col justify-end min-h-[400px]" style="background: rgba(211,228,254,0.5); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.1);">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent opacity-60 z-0"></div>
                        <div class="relative z-10">
                            <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center text-on-primary mb-8 group-hover:scale-110 transition-transform shadow-sm">
                                <span class="material-symbols-outlined text-[32px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                            </div>
                            <h3 class="font-headline-sm text-[32px] font-bold text-on-surface mb-4">Real-time Stock Tracking</h3>
                            <p class="font-body-md text-[18px] text-on-surface-variant leading-relaxed max-w-xl">
                                Precision and absolute control over every SKU. Our proprietary tracking engine provides sub-second updates across multiple global warehouses simultaneously, ensuring you never miss a beat in fulfillment.
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6">
                        <!-- Feature 2 -->
                        <div class="flex-1 p-8 rounded-3xl border border-outline-variant/40 hover:border-secondary/40 transition-all group hover:shadow-[0_0_30px_rgba(111,251,190,0.08)] relative overflow-hidden" style="background: rgba(211,228,254,0.5); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.1);">
                            <div class="w-12 h-12 bg-secondary/15 rounded-lg flex items-center justify-center text-secondary mb-6 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">groups</span>
                            </div>
                            <h3 class="font-headline-sm text-[22px] font-bold text-on-surface mb-3">Resource Management</h3>
                            <p class="font-body-md text-on-surface-variant leading-relaxed">
                                Hiring and workforce optimization built into the workflow. Match personnel expertise with inventory demands.
                            </p>
                        </div>
                        <!-- Feature 3 -->
                        <div class="flex-1 p-8 rounded-3xl border border-outline-variant/40 hover:border-primary/40 transition-all group hover:shadow-[0_0_30px_rgba(195,192,255,0.08)] relative overflow-hidden" style="background: rgba(211,228,254,0.5); backdrop-filter: blur(20px); border: 1px solid rgba(0,0,0,0.1);">
                            <div class="w-12 h-12 bg-primary/15 rounded-lg flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">point_of_sale</span>
                            </div>
                            <h3 class="font-headline-sm text-[22px] font-bold text-on-surface mb-3">Sales Integration</h3>
                            <p class="font-body-md text-on-surface-variant leading-relaxed">
                                Sell supplies and track revenue streams in a unified interface. Native ERP connectors bridge the gap.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Data Visualization Section -->
        <section class="relative pt-32 pb-48 bg-gradient-to-b from-surface-container-low to-surface-container -mb-24 z-10" style="clip-path: polygon(0 10%, 100% 0, 100% 100%, 0 100%);">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                    <div class="lg:col-span-5 relative z-20 text-on-surface">
                        <h2 class="font-headline-lg text-[56px] font-extrabold mb-6 leading-tight">Unrivaled Depth <br/>of Insight</h2>
                        <p class="font-body-lg text-[18px] text-on-surface-variant mb-10 leading-relaxed">
                            Experience the interface designed for power users. Every interaction is optimized for speed, allowing you to drill down from macro trends to individual item histories in seconds.
                        </p>
                        <ul class="space-y-6">
                            <li class="flex items-center gap-4 p-4 rounded-xl shadow-sm border border-outline-variant/30" style="background: rgba(211,228,254,0.55); backdrop-filter: blur(20px);">
                                <span class="material-symbols-outlined text-secondary text-[28px]">check_circle</span>
                                <span class="font-body-md text-[16px] font-bold text-on-surface">Auto-replenishment algorithms</span>
                            </li>
                            <li class="flex items-center gap-4 p-4 rounded-xl shadow-sm border border-outline-variant/30" style="background: rgba(211,228,254,0.55); backdrop-filter: blur(20px);">
                                <span class="material-symbols-outlined text-secondary text-[28px]">check_circle</span>
                                <span class="font-body-md text-[16px] font-bold text-on-surface">Predictive churn modeling</span>
                            </li>
                            <li class="flex items-center gap-4 p-4 rounded-xl shadow-sm border border-outline-variant/30" style="background: rgba(211,228,254,0.55); backdrop-filter: blur(20px);">
                                <span class="material-symbols-outlined text-secondary text-[28px]">check_circle</span>
                                <span class="font-body-md text-[16px] font-bold text-on-surface">Custom multi-tenant reporting</span>
                            </li>
                        </ul>
                    </div>
                    <div class="lg:col-span-7 relative">
                        <div class="absolute -inset-10 bg-primary rounded-full blur-[100px] opacity-15 z-0 animate-pulse"></div>
                        <div class="rounded-2xl shadow-[0_30px_60px_rgba(0,0,0,0.12)] border border-outline-variant/30 overflow-hidden relative z-20 transform translate-y-16" style="background: rgba(211,228,254,0.65); backdrop-filter: blur(20px);">
                            <!-- Table Header -->
                            <div class="px-8 py-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-high/50">
                                <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">Live Inventory Analytics</h4>
                                <div class="flex gap-2">
                                    <span class="px-3 py-1 bg-surface-variant rounded-full text-[12px] font-bold text-on-surface">Q4 REPORT</span>
                                    <span class="px-3 py-1 bg-secondary/15 text-secondary rounded-full text-[12px] font-bold">REAL-TIME</span>
                                </div>
                            </div>
                            <!-- Data Table -->
                            <div class="overflow-x-auto bg-surface-container-lowest/70 backdrop-blur-xl">
                                <table class="w-full text-left">
                                    <thead class="border-b border-outline-variant/30">
                                        <tr>
                                            <th class="px-8 py-4 font-label-md text-label-md text-outline">PRODUCT</th>
                                            <th class="px-8 py-4 font-label-md text-label-md text-outline">STATUS</th>
                                            <th class="px-8 py-4 font-label-md text-label-md text-outline">TREND</th>
                                            <th class="px-8 py-4 font-label-md text-label-md text-outline text-right">VALUE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-outline-variant/30">
                                        <tr class="hover:bg-surface-variant/40 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="flex flex-col">
                                                    <span class="font-data-tabular text-data-tabular text-on-surface font-bold">Industrial Hub 500</span>
                                                    <span class="text-[12px] text-on-surface-variant">SKU: IH-5029</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span class="px-2 py-1 rounded bg-secondary-container/40 text-secondary text-[11px] font-bold border border-secondary/30">OPTIMAL</span>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="w-24 h-6 flex items-end gap-1">
                                                    <div class="bg-secondary/30 w-full h-[40%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[60%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[55%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[80%] rounded-sm"></div>
                                                    <div class="bg-secondary w-full h-[100%] rounded-sm" style="box-shadow: 0 0 8px rgba(0,108,73,0.3);"></div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right font-data-tabular text-data-tabular text-on-surface">$42,900.00</td>
                                        </tr>
                                        <tr class="hover:bg-surface-variant/40 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="flex flex-col">
                                                    <span class="font-data-tabular text-data-tabular text-on-surface font-bold">Precision Actuator X</span>
                                                    <span class="text-[12px] text-on-surface-variant">SKU: PX-9921</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span class="px-2 py-1 rounded bg-error-container text-on-error-container text-[11px] font-bold border border-error/40">LOW STOCK</span>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="w-24 h-6 flex items-end gap-1">
                                                    <div class="bg-error/30 w-full h-[90%] rounded-sm"></div>
                                                    <div class="bg-error/30 w-full h-[70%] rounded-sm"></div>
                                                    <div class="bg-error/30 w-full h-[40%] rounded-sm"></div>
                                                    <div class="bg-error/30 w-full h-[30%] rounded-sm"></div>
                                                    <div class="bg-error w-full h-[20%] rounded-sm" style="box-shadow: 0 0 8px rgba(186,26,26,0.3);"></div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right font-data-tabular text-data-tabular text-on-surface">$18,450.00</td>
                                        </tr>
                                        <tr class="hover:bg-surface-variant/40 transition-colors">
                                            <td class="px-8 py-5">
                                                <div class="flex flex-col">
                                                    <span class="font-data-tabular text-data-tabular text-on-surface font-bold">Fiber Relay Module</span>
                                                    <span class="text-[12px] text-on-surface-variant">SKU: FR-1122</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                <span class="px-2 py-1 rounded bg-secondary-container/40 text-secondary text-[11px] font-bold border border-secondary/30">OPTIMAL</span>
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="w-24 h-6 flex items-end gap-1">
                                                    <div class="bg-secondary/30 w-full h-[20%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[25%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[40%] rounded-sm"></div>
                                                    <div class="bg-secondary/30 w-full h-[35%] rounded-sm"></div>
                                                    <div class="bg-secondary w-full h-[45%] rounded-sm" style="box-shadow: 0 0 8px rgba(0,108,73,0.3);"></div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right font-data-tabular text-data-tabular text-on-surface">$122,100.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="pt-48 pb-32 bg-surface-container relative z-0">
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="bg-gradient-to-r from-on-primary-fixed-variant to-primary rounded-3xl p-16 text-center relative overflow-hidden shadow-2xl border border-white/10">
                    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-white opacity-10 rounded-full blur-[80px] -mr-48 -mt-48"></div>
                    <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-secondary-fixed opacity-20 rounded-full blur-[100px] -ml-48 -mb-48"></div>
                    <div class="relative z-10">
                        <h2 class="font-headline-lg text-[48px] font-extrabold text-on-primary mb-6">Ready to optimize your supply chain?</h2>
                        <p class="font-body-lg text-[20px] text-white/80 max-w-2xl mx-auto mb-12">
                            Join over 400 global enterprises leveraging Invenio Pro to achieve operational excellence. Secure, scalable, and built for professionals.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link v-if="canRegister" :href="route('register')" class="bg-on-primary text-primary px-10 py-4 rounded-xl font-headline-sm text-headline-sm hover:scale-105 transition-transform shadow-xl">
                                Get Started Now
                            </Link>
                            <button v-else class="bg-on-primary text-primary px-10 py-4 rounded-xl font-headline-sm text-headline-sm hover:scale-105 transition-transform shadow-xl">
                                Get Started Now
                            </button>
                            <button class="bg-black/15 backdrop-blur-md border border-white/30 text-on-primary px-10 py-4 rounded-xl font-headline-sm text-headline-sm hover:bg-black/25 transition-colors">
                                Talk to Sales
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full py-16 bg-surface-container border-t border-outline-variant/30">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
                <div class="col-span-1">
                    <span class="font-headline-sm text-headline-sm font-bold text-on-surface mb-6 block">Invenio Pro</span>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6 pr-4">
                        Professional inventory intelligence for the modern industrial age.
                    </p>
                    <div class="flex gap-4">
                        <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">mail</span></a>
                        <a class="text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">hub</span></a>
                    </div>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface font-bold mb-6">Product</h5>
                    <ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Resources</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Documentation</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Case Studies</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface font-bold mb-6">Company</h5>
                    <ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">About Us</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Careers</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-label-md text-label-md text-on-surface font-bold mb-6">Legal</h5>
                    <ul class="space-y-4 font-body-md text-body-md text-on-surface-variant">
                        <li><a class="hover:text-primary transition-colors" href="#">Privacy Policy</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop mt-16 pt-8 border-t border-outline-variant/30 text-center">
                <p class="font-body-md text-body-md text-on-surface-variant">© 2024 Invenio Pro. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap');

body { font-family: 'Inter', sans-serif; }

.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    vertical-align: middle;
}
</style>