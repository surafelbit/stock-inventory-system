<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    suppliers: Array,
});

const form = useForm({
    name: "",
    email: "",
    phone: "",
    address: "",
});

const submit = () => {
    form.post(route("suppliers.store"), {
        onSuccess: () => form.reset(),
    });
};

const deleteSupplier = (id) => {
    if (confirm("Are you sure you want to remove this supplier?")) {
        form.delete(route("suppliers.destroy", id));
    }
};

// Statistics Computations
const activeContactsCount = computed(() => {
    return props.suppliers.filter((s) => s.email || s.phone).length;
});

const locationsCount = computed(() => {
    return props.suppliers.filter(
        (s) => s.address && s.address.trim().length > 0,
    ).length;
});

// Search and Filter logic
const searchQuery = ref("");

const filteredSuppliers = computed(() => {
    if (!searchQuery.value) return props.suppliers;
    const query = searchQuery.value.toLowerCase().trim();
    return props.suppliers.filter((s) => {
        return (
            (s.name && s.name.toLowerCase().includes(query)) ||
            (s.email && s.email.toLowerCase().includes(query)) ||
            (s.phone && s.phone.toLowerCase().includes(query)) ||
            (s.address && s.address.toLowerCase().includes(query))
        );
    });
});

// Navigation helper
const registerCard = ref(null);
const scrollToRegister = () => {
    if (registerCard.value) {
        registerCard.value.scrollIntoView({
            behavior: "smooth",
            block: "center",
        });
    }
};

// Avatar background generator based on name hash
const getAvatarColors = (name) => {
    const charCode = name ? name.charCodeAt(0) : 65;
    const palettes = [
        { bg: "linear-gradient(135deg, #e0d9ff 0%, #c3baff 100%)", color: "#3525cd", border: "rgba(53,37,205,0.25)" },
        { bg: "linear-gradient(135deg, #c9f3e4 0%, #6ffbbe 100%)", color: "#005236", border: "rgba(0,108,73,0.25)" },
        { bg: "linear-gradient(135deg, #fde8d0 0%, #fbcb9a 100%)", color: "#9c4b0a", border: "rgba(180,90,20,0.25)" },
        { bg: "linear-gradient(135deg, #fdd6d6 0%, #f9a8a8 100%)", color: "#920000", border: "rgba(186,26,26,0.25)" },
        { bg: "linear-gradient(135deg, #dce9ff 0%, #b6d0ff 100%)", color: "#1a3f8c", border: "rgba(26,63,140,0.25)" },
    ];
    return palettes[charCode % palettes.length];
};

const getContactCompleteness = (supplier) => {
    let score = 0;
    if (supplier.email) score += 50;
    if (supplier.phone) score += 25;
    if (supplier.address) score += 25;
    return score;
};
</script>

<template>
    <Head title="Suppliers & Vendors" />

    <AuthenticatedLayout>
        <!-- Background Blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
            <div class="blob blob-a absolute -top-40 -left-40 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"></div>
            <div class="blob blob-b absolute top-40 right-0 w-[450px] h-[450px] bg-secondary/10 rounded-full blur-[110px]"></div>
            <div class="blob blob-c absolute bottom-20 left-1/2 w-[350px] h-[350px] bg-tertiary-fixed/20 rounded-full blur-[100px]"></div>
        </div>

        <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- ── Hero Header ── -->
            <div class="mb-8 rounded-3xl relative overflow-hidden" style="background: linear-gradient(135deg, #3525cd 0%, #4f46e5 55%, #6366f1 100%);">
                <!-- Inner grid pattern -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 28px 28px;"></div>
                <!-- Glowing orbs inside hero -->
                <div class="absolute -top-10 -right-10 w-56 h-56 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-8 left-20 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

                <div class="relative z-10 p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-white/20 text-white border border-white/30 uppercase tracking-widest mb-3 backdrop-blur-sm">
                            <span class="material-symbols-outlined text-[13px]">hub</span>
                            Supply Chain Partners
                        </span>
                        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-1" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                            Suppliers & Vendors
                        </h1>
                        <p class="text-white/75 text-sm max-w-md">
                            Register, track, and manage your partner channels and shipping vendors in one unified directory.
                        </p>
                    </div>
                    <div class="flex gap-3 flex-wrap">
                        <button
                            @click="scrollToRegister"
                            class="bg-white text-primary border border-transparent px-5 py-2.5 rounded-xl font-bold text-sm flex items-center gap-2 hover:bg-primary-fixed transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                        >
                            <span class="material-symbols-outlined text-[18px]">add_circle</span>
                            Register Supplier
                        </button>
                    </div>
                </div>
            </div>

            <!-- ── Stat Cards ── -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
                <!-- Total Suppliers -->
                <div class="stat-card p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md bg-white/70 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-full -translate-x-4 -translate-y-8"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #e0d9ff, #c3baff);">
                            <span class="material-symbols-outlined text-[22px] text-primary">local_shipping</span>
                        </div>
                        <span class="text-[10px] font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-full border border-primary/20 uppercase tracking-wider">VENDORS</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Registered Partners</p>
                    <h3 class="text-4xl font-extrabold text-on-surface mt-1 mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ suppliers.length }}
                    </h3>
                    <!-- Progress bar -->
                    <div class="h-1.5 bg-primary/10 rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all duration-700" :style="`width: ${Math.min(suppliers.length * 10, 100)}%`"></div>
                    </div>
                    <p class="text-[11px] text-on-surface-variant mt-2">Active suppliers in your network</p>
                </div>

                <!-- Active Contacts -->
                <div class="stat-card p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md bg-white/70 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-secondary/5 rounded-full -translate-x-4 -translate-y-8"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #c9f3e4, #6ffbbe);">
                            <span class="material-symbols-outlined text-[22px] text-secondary">contact_mail</span>
                        </div>
                        <span class="text-[10px] font-bold text-secondary bg-secondary/10 px-2.5 py-1 rounded-full border border-secondary/20 uppercase tracking-wider">CONTACTS</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Active Contacts</p>
                    <h3 class="text-4xl font-extrabold text-on-surface mt-1 mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ activeContactsCount }}
                    </h3>
                    <div class="h-1.5 bg-secondary/10 rounded-full overflow-hidden">
                        <div class="h-full bg-secondary rounded-full transition-all duration-700" :style="`width: ${suppliers.length ? (activeContactsCount / suppliers.length) * 100 : 0}%`"></div>
                    </div>
                    <p class="text-[11px] text-on-surface-variant mt-2">Vendors with valid email or phone</p>
                </div>

                <!-- Geographic Coverage -->
                <div class="stat-card p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md bg-white/70 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/5 rounded-full -translate-x-4 -translate-y-8"></div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #fde8d0, #fbcb9a);">
                            <span class="material-symbols-outlined text-[22px] text-amber-700">location_on</span>
                        </div>
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-100/60 px-2.5 py-1 rounded-full border border-amber-200 uppercase tracking-wider">LOCATIONS</span>
                    </div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-on-surface-variant">Geographic Coverage</p>
                    <h3 class="text-4xl font-extrabold text-on-surface mt-1 mb-3" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ locationsCount }}
                    </h3>
                    <div class="h-1.5 bg-amber-200/60 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full transition-all duration-700" :style="`width: ${suppliers.length ? (locationsCount / suppliers.length) * 100 : 0}%`"></div>
                    </div>
                    <p class="text-[11px] text-on-surface-variant mt-2">Vendors with physical locations</p>
                </div>
            </div>

            <!-- ── Main Content Grid ── -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Left: Register Form -->
                <div ref="registerCard" class="lg:col-span-4 flex flex-col gap-5">
                    <div class="bg-white/70 backdrop-blur-md p-6 rounded-3xl border border-outline-variant/30 shadow-sm">
                        <!-- Form Header -->
                        <div class="flex items-center gap-3 mb-5 pb-5 border-b border-outline-variant/20">
                            <div class="w-10 h-10 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #e0d9ff, #c3baff);">
                                <span class="material-symbols-outlined text-[20px] text-primary">person_add</span>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-on-surface text-sm" style="font-family: 'Plus Jakarta Sans', sans-serif;">Register New Vendor</h4>
                                <p class="text-[11px] text-on-surface-variant">Create a new supply network partner profile.</p>
                            </div>
                        </div>

                        <form @submit.prevent="submit" class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="supplier_name" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    <span class="material-symbols-outlined text-[14px]">business</span>
                                    Supplier Name <span class="text-error">*</span>
                                </label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    id="supplier_name"
                                    placeholder="e.g. Acme Logistics"
                                    class="block w-full rounded-xl border border-outline-variant/60 bg-white/70 text-on-surface placeholder:text-outline/40 focus:border-primary focus:ring-2 focus:ring-primary/15 text-sm transition-all py-2.5 px-3.5"
                                    :class="{ 'border-error ring-2 ring-error/10': form.errors.name }"
                                    required
                                />
                                <p v-if="form.errors.name" class="text-error text-[11px] mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">error</span>
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="supplier_email" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    <span class="material-symbols-outlined text-[14px]">mail</span>
                                    Email Address
                                </label>
                                <input
                                    v-model="form.email"
                                    type="email"
                                    id="supplier_email"
                                    placeholder="e.g. contact@acme.com"
                                    class="block w-full rounded-xl border border-outline-variant/60 bg-white/70 text-on-surface placeholder:text-outline/40 focus:border-primary focus:ring-2 focus:ring-primary/15 text-sm transition-all py-2.5 px-3.5"
                                    :class="{ 'border-error ring-2 ring-error/10': form.errors.email }"
                                />
                                <p v-if="form.errors.email" class="text-error text-[11px] mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">error</span>
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="supplier_phone" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    <span class="material-symbols-outlined text-[14px]">phone</span>
                                    Phone Number
                                </label>
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    id="supplier_phone"
                                    placeholder="e.g. +1 (555) 019-2834"
                                    class="block w-full rounded-xl border border-outline-variant/60 bg-white/70 text-on-surface placeholder:text-outline/40 focus:border-primary focus:ring-2 focus:ring-primary/15 text-sm transition-all py-2.5 px-3.5"
                                    :class="{ 'border-error ring-2 ring-error/10': form.errors.phone }"
                                />
                                <p v-if="form.errors.phone" class="text-error text-[11px] mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">error</span>
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="supplier_address" class="flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-on-surface-variant mb-1.5">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    Address / Location
                                </label>
                                <textarea
                                    v-model="form.address"
                                    id="supplier_address"
                                    rows="3"
                                    placeholder="e.g. 100 Warehouse Way, Sector 4"
                                    class="block w-full rounded-xl border border-outline-variant/60 bg-white/70 text-on-surface placeholder:text-outline/40 focus:border-primary focus:ring-2 focus:ring-primary/15 text-sm transition-all py-2.5 px-3.5 resize-none"
                                    :class="{ 'border-error ring-2 ring-error/10': form.errors.address }"
                                ></textarea>
                                <p v-if="form.errors.address" class="text-error text-[11px] mt-1 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">error</span>
                                    {{ form.errors.address }}
                                </p>
                            </div>

                            <!-- Submit Button -->
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="submit-btn w-full text-white py-3 px-4 rounded-xl font-bold text-sm shadow-md flex items-center justify-center gap-2 mt-1 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                            >
                                <span v-if="form.processing" class="material-symbols-outlined text-[18px] animate-spin">progress_activity</span>
                                <span v-else class="material-symbols-outlined text-[18px]">save</span>
                                {{ form.processing ? "Saving..." : "Register Vendor" }}
                            </button>
                        </form>
                    </div>

                    <!-- Quick Tips Card -->
                    <div class="bg-primary/5 backdrop-blur-md p-5 rounded-3xl border border-primary/15">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-[18px] text-primary">lightbulb</span>
                            <span class="text-xs font-bold text-primary uppercase tracking-wider">Tips</span>
                        </div>
                        <ul class="space-y-2 text-[12px] text-on-surface-variant">
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-[14px] text-primary/60 mt-0.5">check_circle</span>
                                Add at least email or phone for better reachability.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-[14px] text-primary/60 mt-0.5">check_circle</span>
                                Including an address helps with logistics planning.
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-[14px] text-primary/60 mt-0.5">check_circle</span>
                                You can search the directory by name, email, or phone.
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Directory Table -->
                <div class="lg:col-span-8 bg-white/70 backdrop-blur-md rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">

                    <!-- Table Header -->
                    <div class="px-6 py-5 border-b border-outline-variant/25 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h4 class="font-extrabold text-on-surface text-base" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                                Supplier Directory
                            </h4>
                            <p class="text-[12px] text-on-surface-variant mt-0.5">
                                List of active shipping channels and product suppliers.
                            </p>
                        </div>
                        <!-- Search -->
                        <div class="relative w-full sm:w-72">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline/60 text-[18px]">search</span>
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Search vendors..."
                                class="ps-9 pe-4 py-2.5 w-full rounded-xl border border-outline-variant/50 bg-white/60 text-on-surface placeholder:text-outline/45 focus:border-primary focus:ring-2 focus:ring-primary/10 text-xs transition-all"
                            />
                            <button
                                v-if="searchQuery"
                                @click="searchQuery = ''"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-outline/50 hover:text-on-surface transition-colors"
                            >
                                <span class="material-symbols-outlined text-[16px]">close</span>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Pills Row -->
                    <div class="px-6 py-3 border-b border-outline-variant/15 bg-surface-container-low/30 flex items-center gap-2 flex-wrap">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-outline mr-1">Show:</span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-primary text-on-primary cursor-default">
                            All <span class="ml-1 bg-white/20 px-1.5 py-0.5 rounded-full text-[10px]">{{ suppliers.length }}</span>
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-white/60 text-on-surface-variant border border-outline-variant/30 cursor-default">
                            With Contact <span class="ml-1 bg-outline-variant/20 px-1.5 py-0.5 rounded-full text-[10px]">{{ activeContactsCount }}</span>
                        </span>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-semibold bg-white/60 text-on-surface-variant border border-outline-variant/30 cursor-default">
                            Located <span class="ml-1 bg-outline-variant/20 px-1.5 py-0.5 rounded-full text-[10px]">{{ locationsCount }}</span>
                        </span>
                        <span class="ml-auto text-[11px] text-on-surface-variant">
                            {{ filteredSuppliers.length }} result{{ filteredSuppliers.length !== 1 ? 's' : '' }}
                        </span>
                    </div>

                    <!-- Data Table -->
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-outline-variant/20 bg-surface-container-low/30">
                                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-outline">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[14px]">domain</span>
                                            Vendor
                                        </div>
                                    </th>
                                    <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-widest text-outline">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[14px]">contacts</span>
                                            Contact Details
                                        </div>
                                    </th>
                                    <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-widest text-outline">
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[14px]">pin_drop</span>
                                            Location
                                        </div>
                                    </th>
                                    <th class="px-4 py-3.5 text-[10px] font-bold uppercase tracking-widest text-outline">
                                        Profile
                                    </th>
                                    <th class="px-6 py-3.5 text-[10px] font-bold uppercase tracking-widest text-outline text-right">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/15">
                                <tr
                                    v-for="supplier in filteredSuppliers"
                                    :key="supplier.id"
                                    class="table-row-hover transition-all"
                                >
                                    <!-- Vendor Name -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-2xl flex items-center justify-center font-bold text-sm border flex-shrink-0"
                                                :style="`background: ${getAvatarColors(supplier.name).bg}; color: ${getAvatarColors(supplier.name).color}; border-color: ${getAvatarColors(supplier.name).border}`"
                                            >
                                                {{ supplier.name ? supplier.name.charAt(0).toUpperCase() : "S" }}
                                            </div>
                                            <div>
                                                <span class="font-semibold text-on-surface text-sm block">{{ supplier.name }}</span>
                                                <span class="text-[10px] text-outline/60 font-mono">ID #{{ supplier.id }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Contact Details -->
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col gap-1.5">
                                            <div v-if="supplier.email" class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[14px] text-primary/70">mail</span>
                                                <a :href="`mailto:${supplier.email}`" class="text-[12px] text-primary hover:underline truncate max-w-[160px]">{{ supplier.email }}</a>
                                            </div>
                                            <div v-else class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[14px] text-outline/30">mail</span>
                                                <span class="text-[12px] italic text-outline/40">No email</span>
                                            </div>
                                            <div v-if="supplier.phone" class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[14px] text-secondary/80">phone</span>
                                                <a :href="`tel:${supplier.phone}`" class="text-[12px] text-on-surface hover:underline">{{ supplier.phone }}</a>
                                            </div>
                                            <div v-else class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[14px] text-outline/30">phone</span>
                                                <span class="text-[12px] italic text-outline/40">No phone</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Location -->
                                    <td class="px-4 py-4 max-w-[160px]">
                                        <div v-if="supplier.address" class="flex items-start gap-1.5">
                                            <span class="material-symbols-outlined text-[15px] text-amber-600/80 mt-0.5 flex-shrink-0">location_on</span>
                                            <span class="text-[12px] text-on-surface-variant truncate" :title="supplier.address">{{ supplier.address }}</span>
                                        </div>
                                        <div v-else class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[15px] text-outline/30">location_off</span>
                                            <span class="text-[12px] italic text-outline/40">No address</span>
                                        </div>
                                    </td>

                                    <!-- Profile completeness -->
                                    <td class="px-4 py-4">
                                        <div class="flex flex-col gap-1 min-w-[70px]">
                                            <div class="flex items-center justify-between mb-0.5">
                                                <span class="text-[10px] text-on-surface-variant">{{ getContactCompleteness(supplier) }}%</span>
                                            </div>
                                            <div class="h-1.5 w-16 bg-outline-variant/20 rounded-full overflow-hidden">
                                                <div
                                                    class="h-full rounded-full transition-all duration-500"
                                                    :class="{
                                                        'bg-error': getContactCompleteness(supplier) < 50,
                                                        'bg-amber-500': getContactCompleteness(supplier) >= 50 && getContactCompleteness(supplier) < 75,
                                                        'bg-secondary': getContactCompleteness(supplier) >= 75,
                                                    }"
                                                    :style="`width: ${getContactCompleteness(supplier)}%`"
                                                ></div>
                                            </div>
                                            <span
                                                class="text-[10px] font-semibold"
                                                :class="{
                                                    'text-error': getContactCompleteness(supplier) < 50,
                                                    'text-amber-600': getContactCompleteness(supplier) >= 50 && getContactCompleteness(supplier) < 75,
                                                    'text-secondary': getContactCompleteness(supplier) >= 75,
                                                }"
                                            >
                                                {{ getContactCompleteness(supplier) < 50 ? 'Incomplete' : getContactCompleteness(supplier) < 75 ? 'Partial' : 'Complete' }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 text-right">
                                        <button
                                            @click="deleteSupplier(supplier.id)"
                                            class="delete-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[12px] font-semibold text-error bg-error-container/20 hover:bg-error-container/50 border border-error/10 hover:border-error/30 transition-all"
                                            title="Delete Supplier"
                                        >
                                            <span class="material-symbols-outlined text-[15px]">delete</span>
                                            Remove
                                        </button>
                                    </td>
                                </tr>

                                <!-- Empty State -->
                                <tr v-if="filteredSuppliers.length === 0">
                                    <td colspan="5" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center gap-3">
                                            <div class="w-16 h-16 rounded-3xl bg-outline-variant/15 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-[32px] text-outline/40">
                                                    {{ searchQuery ? 'search_off' : 'local_shipping' }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-on-surface-variant text-sm">
                                                    {{ searchQuery ? "No results found" : "No suppliers yet" }}
                                                </p>
                                                <p class="text-[12px] text-outline/60 mt-1">
                                                    {{ searchQuery ? `No suppliers match "${searchQuery}". Try a different search.` : "Add your first supplier to begin building your network!" }}
                                                </p>
                                            </div>
                                            <button
                                                v-if="searchQuery"
                                                @click="searchQuery = ''"
                                                class="mt-1 px-4 py-2 rounded-xl text-xs font-semibold bg-primary/10 text-primary border border-primary/20 hover:bg-primary/15 transition-all"
                                            >
                                                Clear Search
                                            </button>
                                            <button
                                                v-else
                                                @click="scrollToRegister"
                                                class="mt-1 px-4 py-2 rounded-xl text-xs font-semibold bg-primary text-on-primary hover:bg-primary-container transition-all shadow-sm"
                                            >
                                                Register First Supplier
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer -->
                    <div class="px-6 py-3.5 border-t border-outline-variant/20 bg-surface-container-low/20 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-secondary animate-pulse"></div>
                            <span class="text-[11px] text-on-surface-variant">
                                Showing <strong class="text-on-surface">{{ filteredSuppliers.length }}</strong> of <strong class="text-on-surface">{{ suppliers.length }}</strong> suppliers
                            </span>
                        </div>
                        <span class="text-[11px] text-outline/50">Updated in real time</span>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Stat card hover */
.stat-card {
    transition: transform 0.35s ease, box-shadow 0.35s ease, border-color 0.35s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(53, 37, 205, 0.09);
    border-color: rgba(53, 37, 205, 0.22) !important;
}

/* Table row hover */
.table-row-hover:hover {
    background: rgba(211, 228, 254, 0.25);
}

/* Delete button hover enhancement */
.delete-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(186, 26, 26, 0.15);
}

/* Submit button gradient */
.submit-btn {
    background: linear-gradient(135deg, #3525cd, #4f46e5);
    transition: all 0.25s ease;
}
.submit-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, #2a1db0, #3f37d4);
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(53, 37, 205, 0.3);
}

/* Floating blobs */
.blob {
    animation: floatBlob 12s ease-in-out infinite;
}
.blob-a { animation-duration: 14s; }
.blob-b { animation-duration: 10s; animation-delay: -3s; }
.blob-c { animation-duration: 16s; animation-delay: -6s; }

@keyframes floatBlob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(20px, -15px) scale(1.05); }
    66% { transform: translate(-15px, 20px) scale(0.96); }
}

@media (prefers-reduced-motion: reduce) {
    .blob, .stat-card, .delete-btn, .submit-btn {
        animation: none !important;
        transition: none !important;
    }
}
</style>
