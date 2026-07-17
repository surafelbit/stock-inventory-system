<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recentProducts: {
        type: Array,
        required: true,
    },
    categoryCounts: {
        type: Array,
        required: true,
    }
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value || 0);
};

const getStockStatus = (stock) => {
    if (stock === 0) {
        return { label: 'OUT OF STOCK', badgeClass: 'bg-error-container/40 text-error border-error/20' };
    }
    if (stock < 10) {
        return { label: 'LOW STOCK', badgeClass: 'bg-amber-100 text-amber-800 border-amber-200' };
    }
    return { label: 'OPTIMAL', badgeClass: 'bg-secondary-container/40 text-secondary border-secondary/30' };
};
</script>

<template>
    <Head title="Enterprise Dashboard" />

    <AuthenticatedLayout>
        <!-- Background Blobs for Visual Interest -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
            <div class="blob blob-a absolute -top-40 -left-40 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"></div>
            <div class="blob blob-b absolute top-40 right-0 w-[450px] h-[450px] bg-secondary/10 rounded-full blur-[110px]"></div>
        </div>

        <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header Welcome Card -->
            <div class="mb-8 p-8 rounded-3xl border border-outline-variant/30 backdrop-blur-md relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6" style="background: rgba(211, 228, 254, 0.45);">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-widest mb-3">
                        Operational Status: Active
                    </span>
                    <h1 class="text-3xl font-bold tracking-tight text-on-surface font-headline-lg" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Welcome back, {{ $page.props.auth.user.name }}
                    </h1>
                    <p class="text-on-surface-variant font-body-md mt-1">
                        Here is your supply chain intelligence summary for <span class="font-semibold text-primary">{{ $page.props.auth.company.name }}</span>.
                    </p>
                </div>
                <div class="flex gap-3">
                    <Link :href="route('products.index')" class="btn-shimmer bg-primary text-on-primary px-5 py-2.5 rounded-xl font-label-md text-label-md flex items-center gap-2 hover:bg-primary-container transition-all shadow-md">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span> Add Product
                    </Link>
                    <Link :href="route('categories.index')" class="bg-surface-container-highest/60 hover:bg-surface-container-highest text-on-surface border border-outline-variant/30 px-5 py-2.5 rounded-xl font-label-md text-label-md flex items-center gap-2 hover:-translate-y-0.5 transition-all">
                        <span class="material-symbols-outlined text-[18px]">category</span> New Category
                    </Link>
                </div>
            </div>

            <!-- Stats Metric Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Stat 1: Total Products -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                        </div>
                        <span class="text-[11px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full border border-primary/20">ITEMS</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Total SKU Catalog</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ stats.totalProducts }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                        <span class="text-secondary font-bold">100% scoped</span> to active company
                    </p>
                </div>

                <!-- Stat 2: Total Stock -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-secondary/15 rounded-2xl flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[24px]">widgets</span>
                        </div>
                        <span class="text-[11px] font-bold text-secondary bg-secondary/15 px-2 py-0.5 rounded-full border border-secondary/20">VOLUME</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Units in Warehouses</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ stats.totalStock }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Total units across all items
                    </p>
                </div>

                <!-- Stat 3: Total Stock Value -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-tertiary-fixed-dim/20 rounded-2xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[24px]">payments</span>
                        </div>
                        <span class="text-[11px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full border border-primary/20">VALUATION</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Total Valuation (Cost)</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ formatCurrency(stats.stockValue) }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Asset value based on cost price
                    </p>
                </div>

                <!-- Stat 4: Low Stock Count -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70" :class="{ 'border-error/30 bg-error-container/10': stats.lowStockCount > 0 }">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" :class="stats.lowStockCount > 0 ? 'bg-error/15 text-error' : 'bg-green-100 text-green-700'">
                            <span class="material-symbols-outlined text-[24px]">{{ stats.lowStockCount > 0 ? 'warning' : 'check_circle' }}</span>
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full border" :class="stats.lowStockCount > 0 ? 'text-error bg-error/10 border-error/20' : 'text-green-700 bg-green-100 border-green-200'">
                            {{ stats.lowStockCount > 0 ? 'CRITICAL' : 'SECURE' }}
                        </span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Low Stock SKU Alerts</p>
                    <h3 class="text-3xl font-extrabold font-headline-lg mt-1" :class="stats.lowStockCount > 0 ? 'text-error' : 'text-on-surface'" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ stats.lowStockCount }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        SKUs with stock quantity &lt; 10
                    </p>
                </div>
            </div>

            <!-- Ledger & Categories Split Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left: Recent Stock Ledger -->
                <div class="lg:col-span-8 bg-white/60 backdrop-blur-md rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Section Header -->
                        <div class="px-8 py-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-high/20">
                            <div>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface font-extrabold" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    Live Stock Ledger
                                </h4>
                                <p class="text-xs text-on-surface-variant mt-0.5">Most recently created or updated products</p>
                            </div>
                            <Link :href="route('products.index')" class="text-xs font-bold text-primary hover:text-primary-container flex items-center gap-1 transition-colors">
                                View Full Catalog <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </Link>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-outline-variant/20 bg-surface-container-low/40">
                                        <th class="px-8 py-4 font-label-md text-label-md text-outline">PRODUCT / SKU</th>
                                        <th class="px-6 py-4 font-label-md text-label-md text-outline">CATEGORY</th>
                                        <th class="px-6 py-4 font-label-md text-label-md text-outline">STATUS</th>
                                        <th class="px-6 py-4 font-label-md text-label-md text-outline text-right">STOCK</th>
                                        <th class="px-8 py-4 font-label-md text-label-md text-outline text-right">RETAIL PRICE</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/20">
                                    <tr v-for="product in recentProducts" :key="product.id" class="hover:bg-surface-variant/25 transition-colors">
                                        <td class="px-8 py-4">
                                            <div class="flex flex-col">
                                                <span class="font-semibold text-on-surface text-sm">{{ product.name }}</span>
                                                <span class="text-[11px] text-on-surface-variant font-mono">SKU: {{ product.sku }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-on-surface-variant">
                                            <span v-if="product.category" class="bg-surface-container-high text-on-surface text-xs px-2.5 py-1 rounded-md border border-outline-variant/30">
                                                {{ product.category.name }}
                                            </span>
                                            <span v-else class="text-outline text-xs italic">Uncategorized</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border" :class="getStockStatus(product.stock).badgeClass">
                                                {{ getStockStatus(product.stock).label }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right font-semibold text-sm" :class="product.stock < 10 ? 'text-amber-700' : 'text-on-surface'">
                                            {{ product.stock }}
                                        </td>
                                        <td class="px-8 py-4 text-right font-semibold text-sm text-on-surface">
                                            {{ formatCurrency(product.price) }}
                                        </td>
                                    </tr>
                                    <tr v-if="recentProducts.length === 0">
                                        <td colspan="5" class="px-8 py-10 text-center text-on-surface-variant italic">
                                            No products registered yet. Click "Add Product" to get started!
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-8 py-4 border-t border-outline-variant/20 bg-surface-container-low/20 text-center">
                        <span class="text-xs text-on-surface-variant">Showing up to 5 latest records. Updated in real time.</span>
                    </div>
                </div>

                <!-- Right: Category Distribution & Quick Links -->
                <div class="lg:col-span-4 flex flex-col gap-8">
                    <!-- Category Stats Panel -->
                    <div class="bg-white/60 backdrop-blur-md rounded-3xl border border-outline-variant/30 shadow-sm p-6">
                        <h4 class="font-headline-sm text-headline-sm text-on-surface font-extrabold mb-4" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Stock by Category
                        </h4>
                        
                        <div class="space-y-4">
                            <div v-for="cat in categoryCounts" :key="cat.id" class="flex flex-col">
                                <div class="flex justify-between items-center text-xs font-semibold mb-1">
                                    <span class="text-on-surface">{{ cat.name }}</span>
                                    <span class="text-on-surface-variant">{{ cat.count }} {{ cat.count === 1 ? 'Product' : 'Products' }}</span>
                                </div>
                                <div class="w-full bg-surface-container rounded-full h-2 overflow-hidden border border-outline-variant/20">
                                    <div class="bg-primary h-2 rounded-full transition-all duration-500" :style="{ width: stats.totalProducts > 0 ? `${(cat.count / stats.totalProducts) * 100}%` : '0%' }"></div>
                                </div>
                            </div>

                            <div v-if="categoryCounts.length === 0" class="text-center py-6 text-xs text-on-surface-variant italic">
                                No categories created yet.
                            </div>
                        </div>
                    </div>

                    <!-- Operations Panel -->
                    <div class="bg-gradient-to-br from-primary via-primary/95 to-surface-tint text-on-primary rounded-3xl p-6 shadow-md relative overflow-hidden">
                        <div class="blob blob-d absolute top-0 right-0 w-[200px] h-[200px] bg-white/10 rounded-full blur-[40px] pointer-events-none"></div>
                        <div class="relative z-10">
                            <h4 class="font-headline-sm text-headline-sm font-extrabold mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Quick Operations
                            </h4>
                            <p class="text-white/80 text-xs mb-6">Streamline inventory management tasks in one tap.</p>

                            <div class="flex flex-col gap-3">
                                <Link :href="route('products.index')" class="flex justify-between items-center p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/10 group">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[20px]">inventory</span>
                                        <span class="text-xs font-bold">Manage Products</span>
                                    </div>
                                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </Link>
                                <Link :href="route('categories.index')" class="flex justify-between items-center p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/10 group">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[20px]">category</span>
                                        <span class="text-xs font-bold">Manage Categories</span>
                                    </div>
                                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </Link>
                                <Link :href="route('suppliers.index')" class="flex justify-between items-center p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-all border border-white/10 group">
                                    <div class="flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                                        <span class="text-xs font-bold">Manage Suppliers</span>
                                    </div>
                                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Card hover lift + glow */
.card-hover { transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease; }
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(53, 37, 205, 0.08);
    border-color: rgba(53, 37, 205, 0.25) !important;
}

/* Floating blobs */
.blob { animation: floatBlob 12s ease-in-out infinite; }
.blob-a { animation-duration: 14s; }
.blob-b { animation-duration: 10s; animation-delay: -3s; }
.blob-d { animation-duration: 11s; }
@keyframes floatBlob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(20px, -15px) scale(1.05); }
    66% { transform: translate(-15px, 20px) scale(0.96); }
}

@media (prefers-reduced-motion: reduce) {
    .blob, .card-hover, .btn-shimmer::after { animation: none !important; transition: none !important; }
}
</style>
