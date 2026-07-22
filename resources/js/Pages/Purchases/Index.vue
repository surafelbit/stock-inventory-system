<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref, watch } from "vue";

const props = defineProps({
    purchases: {
        type: Array,
        default: () => [],
    },
    suppliers: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
});

// Form state
const form = useForm({
    supplier_id: "",
    product_id: "",
    quantity: 1,
    cost_price: "",
});

// Form focus reference
const productSelectRef = ref(null);

// Selected product object
const selectedProduct = computed(() => {
    if (!form.product_id) return null;
    return props.products.find((p) => p.id === parseInt(form.product_id));
});

// Selected supplier object
const selectedSupplier = computed(() => {
    if (!form.supplier_id) return null;
    return props.suppliers.find((s) => s.id === parseInt(form.supplier_id));
});

// Auto-fill cost price when a product is selected
watch(
    () => form.product_id,
    (newProductId) => {
        if (!newProductId) {
            form.cost_price = "";
            return;
        }
        const foundProduct = props.products.find(
            (p) => p.id === parseInt(newProductId)
        );
        if (foundProduct && foundProduct.cost_price !== undefined) {
            form.cost_price = foundProduct.cost_price;
        }
    }
);

// Submit handler
const submit = () => {
    form.post(route("purchases.store"), {
        onSuccess: () => {
            form.reset("quantity", "cost_price");
        },
    });
};

// Search & Filter state
const searchQuery = ref("");
const filterSupplierId = ref("");

const filteredPurchases = computed(() => {
    return props.purchases.filter((p) => {
        // Supplier filter
        if (
            filterSupplierId.value &&
            p.supplier_id !== parseInt(filterSupplierId.value)
        ) {
            return false;
        }

        // Text search
        if (!searchQuery.value) return true;
        const query = searchQuery.value.toLowerCase().trim();
        const productName = p.product ? p.product.name.toLowerCase() : "";
        const supplierName = p.supplier ? p.supplier.name.toLowerCase() : "";
        const dateStr = p.created_at
            ? new Date(p.created_at).toLocaleDateString().toLowerCase()
            : "";

        return (
            productName.includes(query) ||
            supplierName.includes(query) ||
            dateStr.includes(query)
        );
    });
});

// Statistics computations
const totalInboundSpend = computed(() => {
    return props.purchases.reduce(
        (sum, p) => sum + parseFloat(p.total_price || 0),
        0
    );
});

const totalUnitsReceived = computed(() => {
    return props.purchases.reduce(
        (sum, p) => sum + parseInt(p.quantity || 0),
        0
    );
});

const totalTransactions = computed(() => {
    return props.purchases.length;
});

const uniqueVendorsCount = computed(() => {
    const ids = new Set(
        props.purchases.map((p) => p.supplier_id).filter(Boolean)
    );
    return ids.size;
});

// Currency Formatter
const formatCurrency = (val) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
    }).format(val || 0);
};

// Date Formatter
const formatDate = (dateString) => {
    if (!dateString) return "N/A";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        month: "short",
        day: "numeric",
        year: "numeric",
    }).format(date);
};

const formatTime = (dateString) => {
    if (!dateString) return "";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        hour: "numeric",
        minute: "numeric",
        hour12: true,
    }).format(date);
};

// Supplier Avatar Gradient Generator
const getSupplierAvatar = (name) => {
    const firstChar = name ? name.toUpperCase().charCodeAt(0) : 65;
    const gradients = [
        "linear-gradient(135deg, #6366f1 0%, #4338ca 100%)",
        "linear-gradient(135deg, #10b981 0%, #047857 100%)",
        "linear-gradient(135deg, #f59e0b 0%, #b45309 100%)",
        "linear-gradient(135deg, #ec4899 0%, #be185d 100%)",
        "linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)",
    ];
    return gradients[firstChar % gradients.length];
};
</script>

<template>
    <Head title="Stock Inflow (Purchases)" />

    <AuthenticatedLayout>
        <!-- Dynamic Background Glowing Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
            <div class="blob blob-a absolute -top-40 -left-40 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"></div>
            <div class="blob blob-b absolute top-40 right-0 w-[450px] h-[450px] bg-secondary/10 rounded-full blur-[110px]"></div>
            <div class="blob blob-c absolute bottom-20 left-1/3 w-[400px] h-[400px] bg-tertiary-fixed/20 rounded-full blur-[100px]"></div>
        </div>

        <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-8">
            
            <!-- Page Hero Header Card -->
            <div class="p-8 rounded-3xl border border-outline-variant/30 backdrop-blur-md relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6 shadow-sm" style="background: rgba(211, 228, 254, 0.45);">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-widest mb-3">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Inventory Logistics & Inward Intake
                    </span>
                    <h1 class="text-3xl font-extrabold tracking-tight text-on-surface font-headline-lg" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        Stock Inflow & Procurement
                    </h1>
                    <p class="text-on-surface-variant font-body-md mt-1 max-w-2xl">
                        Record vendor inventory purchases, track incoming stock movements, auto-update warehouse stock levels, and audit total inbound expenditure.
                    </p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs text-on-surface-variant font-medium">Total Procurement Budget</span>
                        <span class="text-2xl font-extrabold text-primary font-headline-lg" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ formatCurrency(totalInboundSpend) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- KPI Metric Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat 1: Total Inbound Spend -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[24px]">payments</span>
                        </div>
                        <span class="text-[11px] font-bold text-primary bg-primary/10 px-2.5 py-0.5 rounded-full border border-primary/20">CAPITAL</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Total Inbound Spend</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ formatCurrency(totalInboundSpend) }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs text-secondary">trending_up</span> Across {{ totalTransactions }} purchases recorded
                    </p>
                </div>

                <!-- Stat 2: Total Units Received -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-secondary/15 rounded-2xl flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[24px]">move_to_inbox</span>
                        </div>
                        <span class="text-[11px] font-bold text-secondary bg-secondary/15 px-2.5 py-0.5 rounded-full border border-secondary/20">UNITS</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Units Received</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        +{{ totalUnitsReceived.toLocaleString() }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Directly added to product stock
                    </p>
                </div>

                <!-- Stat 3: Total Transactions -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-600">
                            <span class="material-symbols-outlined text-[24px]">receipt_long</span>
                        </div>
                        <span class="text-[11px] font-bold text-amber-700 bg-amber-100 px-2.5 py-0.5 rounded-full border border-amber-200">BATCHES</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Inbound Batches</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ totalTransactions }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Logged purchase receipts
                    </p>
                </div>

                <!-- Stat 4: Active Vendors -->
                <div class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70 shadow-sm">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-600">
                            <span class="material-symbols-outlined text-[24px]">local_shipping</span>
                        </div>
                        <span class="text-[11px] font-bold text-indigo-700 bg-indigo-100 px-2.5 py-0.5 rounded-full border border-indigo-200">VENDORS</span>
                    </div>
                    <p class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant">Active Suppliers</p>
                    <h3 class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ uniqueVendorsCount }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Suppliers fulfilling orders
                    </p>
                </div>
            </div>

            <!-- Main Interactive Split Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Section: Record Stock Purchase Form (4 Cols on LG) -->
                <div class="lg:col-span-4 bg-white/80 backdrop-blur-xl p-6 rounded-3xl border border-outline-variant/30 shadow-md relative overflow-hidden">
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-outline-variant/20">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-[22px]">add_shopping_cart</span>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-on-surface font-headline-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    Record Purchase
                                </h2>
                                <p class="text-xs text-on-surface-variant">Intake stock & increment ledger</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-secondary/10 text-secondary border border-secondary/20 uppercase tracking-wider">
                            Live Intake
                        </span>
                    </div>

                    <form @submit.prevent="submit" class="space-y-5">
                        
                        <!-- Supplier Select Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                Supplier / Vendor <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    v-model="form.supplier_id"
                                    class="w-full rounded-2xl border border-outline-variant/40 bg-surface-container-low/50 px-4 py-2.5 text-sm font-medium text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer"
                                    required
                                >
                                    <option value="" disabled>Select a supplier vendor...</option>
                                    <option
                                        v-for="sup in suppliers"
                                        :key="sup.id"
                                        :value="sup.id"
                                    >
                                        {{ sup.name }}
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-sm">unfold_more</span>
                                </div>
                            </div>
                            <p v-if="form.errors.supplier_id" class="text-error text-xs mt-1.5 flex items-center gap-1 font-medium">
                                <span class="material-symbols-outlined text-xs">error</span> {{ form.errors.supplier_id }}
                            </p>
                        </div>

                        <!-- Product Select Field -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                Product <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    ref="productSelectRef"
                                    v-model="form.product_id"
                                    class="w-full rounded-2xl border border-outline-variant/40 bg-surface-container-low/50 px-4 py-2.5 text-sm font-medium text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer"
                                    required
                                >
                                    <option value="" disabled>Select a product to restock...</option>
                                    <option
                                        v-for="prod in products"
                                        :key="prod.id"
                                        :value="prod.id"
                                    >
                                        {{ prod.name }} (Current Stock: {{ prod.stock }})
                                    </option>
                                </select>
                                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-sm">unfold_more</span>
                                </div>
                            </div>
                            <p v-if="form.errors.product_id" class="text-error text-xs mt-1.5 flex items-center gap-1 font-medium">
                                <span class="material-symbols-outlined text-xs">error</span> {{ form.errors.product_id }}
                            </p>
                            
                            <!-- Selected Product Preview Badge -->
                            <div v-if="selectedProduct" class="mt-2.5 p-3 rounded-2xl bg-surface-container-low/80 border border-outline-variant/30 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-base">inventory_2</span>
                                    <div>
                                        <div class="font-bold text-on-surface">{{ selectedProduct.name }}</div>
                                        <div class="text-[11px] text-on-surface-variant">Default Cost: {{ formatCurrency(selectedProduct.cost_price) }}</div>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-lg bg-primary/10 text-primary font-bold text-[11px]">
                                    Stock: {{ selectedProduct.stock }}
                                </span>
                            </div>
                        </div>

                        <!-- Inputs Grid: Quantity & Cost Price -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    Quantity <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        v-model="form.quantity"
                                        type="number"
                                        min="1"
                                        step="1"
                                        class="w-full rounded-2xl border border-outline-variant/40 bg-surface-container-low/50 px-4 py-2.5 text-sm font-bold text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        required
                                    />
                                </div>
                                <p v-if="form.errors.quantity" class="text-error text-xs mt-1">
                                    {{ form.errors.quantity }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    Unit Cost ($) <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <input
                                        v-model="form.cost_price"
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        placeholder="0.00"
                                        class="w-full rounded-2xl border border-outline-variant/40 bg-surface-container-low/50 px-4 py-2.5 text-sm font-bold text-on-surface focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        required
                                    />
                                </div>
                                <p v-if="form.errors.cost_price" class="text-error text-xs mt-1">
                                    {{ form.errors.cost_price }}
                                </p>
                            </div>
                        </div>

                        <!-- Live Cost & Stock Impact Card -->
                        <div v-if="form.quantity && form.cost_price" class="p-4 rounded-2xl bg-gradient-to-br from-primary/5 to-secondary/10 border border-primary/20 space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-on-surface-variant font-medium">Unit Price × Quantity:</span>
                                <span class="font-semibold text-on-surface">
                                    {{ formatCurrency(form.cost_price) }} × {{ form.quantity }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-primary/10">
                                <span class="text-xs font-bold uppercase tracking-wider text-on-surface">Total Purchase Cost:</span>
                                <span class="text-lg font-extrabold text-primary font-headline-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                    {{ formatCurrency(form.quantity * form.cost_price) }}
                                </span>
                            </div>
                            
                            <div v-if="selectedProduct" class="pt-2 border-t border-primary/10 flex items-center justify-between text-[11px] text-secondary font-medium">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">auto_graph</span> Projected Stock After Receive:
                                </span>
                                <span class="font-bold bg-secondary/15 px-2 py-0.5 rounded-md">
                                    {{ selectedProduct.stock }} → {{ selectedProduct.stock + parseInt(form.quantity || 0) }} units
                                </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full btn-shimmer bg-primary hover:bg-primary-container text-on-primary py-3.5 px-5 rounded-2xl font-label-lg font-bold text-sm flex items-center justify-center gap-2 shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
                        >
                            <span v-if="form.processing" class="inline-block animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></span>
                            <span v-else class="material-symbols-outlined text-[20px]">add_task</span>
                            <span>{{ form.processing ? "Processing Intake..." : "Receive Stock & Add to Inventory" }}</span>
                        </button>
                    </form>
                </div>

                <!-- Right Section: Inbound History Ledger Table (8 Cols on LG) -->
                <div class="lg:col-span-8 bg-white/80 backdrop-blur-xl rounded-3xl border border-outline-variant/30 shadow-md overflow-hidden flex flex-col justify-between">
                    <div>
                        <!-- Header & Search Controls Bar -->
                        <div class="p-6 border-b border-outline-variant/20 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-low/30">
                            <div>
                                <div class="flex items-center gap-2">
                                    <h3 class="text-lg font-bold text-on-surface font-headline-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                        Stock Inbound History
                                    </h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-primary/10 text-primary border border-primary/20">
                                        {{ filteredPurchases.length }} Entries
                                    </span>
                                </div>
                                <p class="text-xs text-on-surface-variant mt-0.5">
                                    Audit log of all incoming stock batches received from suppliers
                                </p>
                            </div>

                            <!-- Filter & Search Controls -->
                            <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
                                <!-- Search Input -->
                                <div class="relative flex-1 sm:w-56">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search product, vendor..."
                                        class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-outline-variant/40 bg-surface/80 text-on-surface focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all"
                                    />
                                    <button
                                        v-if="searchQuery"
                                        @click="searchQuery = ''"
                                        class="absolute right-2.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface text-xs"
                                    >
                                        ×
                                    </button>
                                </div>

                                <!-- Supplier Filter Dropdown -->
                                <select
                                    v-model="filterSupplierId"
                                    class="py-1.5 px-3 text-xs rounded-xl border border-outline-variant/40 bg-surface/80 text-on-surface focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all cursor-pointer"
                                >
                                    <option value="">All Suppliers</option>
                                    <option v-for="sup in suppliers" :key="sup.id" :value="sup.id">
                                        {{ sup.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-outline-variant/20 bg-surface-container-low/50 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">
                                        <th class="py-3.5 px-6">Date & Time</th>
                                        <th class="py-3.5 px-6">Product Details</th>
                                        <th class="py-3.5 px-6">Supplier Vendor</th>
                                        <th class="py-3.5 px-6 text-center">Qty Added</th>
                                        <th class="py-3.5 px-6 text-right">Unit Price</th>
                                        <th class="py-3.5 px-6 text-right">Total Inbound Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/15 text-sm">
                                    <tr
                                        v-for="p in filteredPurchases"
                                        :key="p.id"
                                        class="hover:bg-primary/5 transition-colors group"
                                    >
                                        <!-- Date Column -->
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="font-semibold text-on-surface text-xs">
                                                {{ formatDate(p.created_at) }}
                                            </div>
                                            <div class="text-[11px] text-on-surface-variant">
                                                {{ formatTime(p.created_at) }}
                                            </div>
                                        </td>

                                        <!-- Product Column -->
                                        <td class="py-4 px-6">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary shrink-0">
                                                    <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-on-surface text-sm group-hover:text-primary transition-colors">
                                                        {{ p.product ? p.product.name : 'Deleted Product' }}
                                                    </div>
                                                    <div v-if="p.product" class="text-[11px] text-on-surface-variant">
                                                        Current Stock: <span class="font-semibold text-on-surface">{{ p.product.stock }}</span> units
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Supplier Column -->
                                        <td class="py-4 px-6 whitespace-nowrap">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg text-white font-bold text-xs flex items-center justify-center shadow-xs shrink-0"
                                                    :style="{ background: getSupplierAvatar(p.supplier ? p.supplier.name : 'U') }"
                                                >
                                                    {{ p.supplier && p.supplier.name ? p.supplier.name.charAt(0).toUpperCase() : 'U' }}
                                                </div>
                                                <span class="font-medium text-on-surface text-xs">
                                                    {{ p.supplier ? p.supplier.name : 'Unknown Vendor' }}
                                                </span>
                                            </div>
                                        </td>

                                        <!-- Quantity Column -->
                                        <td class="py-4 px-6 text-center whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-secondary/15 text-secondary border border-secondary/20">
                                                <span class="material-symbols-outlined text-[14px]">trending_up</span>
                                                +{{ p.quantity }}
                                            </span>
                                        </td>

                                        <!-- Unit Cost Column -->
                                        <td class="py-4 px-6 text-right whitespace-nowrap text-xs font-medium text-on-surface-variant">
                                            {{ formatCurrency(p.cost_price) }}
                                        </td>

                                        <!-- Total Cost Column -->
                                        <td class="py-4 px-6 text-right whitespace-nowrap">
                                            <span class="font-extrabold text-on-surface text-sm font-headline-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                                {{ formatCurrency(p.total_price) }}
                                            </span>
                                        </td>
                                    </tr>

                                    <!-- Empty State -->
                                    <tr v-if="filteredPurchases.length === 0">
                                        <td colspan="6" class="py-12 text-center">
                                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                                <div class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant mb-3">
                                                    <span class="material-symbols-outlined text-[32px]">shopping_bag</span>
                                                </div>
                                                <h4 class="font-bold text-on-surface text-base">No Inbound Purchases Found</h4>
                                                <p class="text-xs text-on-surface-variant mt-1 text-center">
                                                    {{ searchQuery || filterSupplierId ? 'No purchase records match your search or filter criteria.' : 'No stock purchases have been recorded yet. Use the intake form on the left to receive your first batch.' }}
                                                </p>
                                                <button
                                                    v-if="searchQuery || filterSupplierId"
                                                    @click="searchQuery = ''; filterSupplierId = '';"
                                                    class="mt-4 px-4 py-2 rounded-xl text-xs font-bold bg-surface-container-highest text-on-surface border border-outline-variant/30 hover:bg-surface-container-high transition-all"
                                                >
                                                    Clear Search & Filters
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary Table Footer -->
                    <div v-if="filteredPurchases.length > 0" class="p-4 bg-surface-container-low/40 border-t border-outline-variant/20 flex flex-col sm:flex-row justify-between items-center text-xs text-on-surface-variant gap-2">
                        <div>
                            Showing <span class="font-bold text-on-surface">{{ filteredPurchases.length }}</span> of <span class="font-bold text-on-surface">{{ purchases.length }}</span> recorded inward receipts
                        </div>
                        <div class="flex items-center gap-4">
                            <span>Filtered Units: <strong class="text-secondary font-bold">+{{ filteredPurchases.reduce((s, p) => s + parseInt(p.quantity||0), 0) }}</strong></span>
                            <span>Filtered Total: <strong class="text-primary font-bold">{{ formatCurrency(filteredPurchases.reduce((s, p) => s + parseFloat(p.total_price||0), 0)) }}</strong></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.btn-shimmer {
    background-size: 200% 100%;
    transition: all 0.3s ease;
}

.card-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
}
</style>
