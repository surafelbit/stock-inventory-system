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
const getAvatarClass = (name) => {
    const charCode = name ? name.charCodeAt(0) : 65;
    const gradients = [
        "from-primary/10 to-primary/30 text-primary border-primary/20",
        "from-secondary/15 to-secondary/35 text-secondary border-secondary/25",
        "from-purple-100 to-purple-300 text-purple-800 border-purple-200",
        "from-amber-100 to-amber-300 text-amber-800 border-amber-200",
        "from-rose-100 to-rose-300 text-rose-800 border-rose-200",
    ];
    return gradients[charCode % gradients.length];
};
</script>

<template>
    <Head title="Suppliers & Vendors" />

    <AuthenticatedLayout>
        <!-- Background Blobs for Visual Interest -->
        <div
            class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10"
        >
            <div
                class="blob blob-a absolute -top-40 -left-40 w-[600px] h-[600px] bg-primary/10 rounded-full blur-[120px]"
            ></div>
            <div
                class="blob blob-b absolute top-40 right-0 w-[450px] h-[450px] bg-secondary/10 rounded-full blur-[110px]"
            ></div>
        </div>

        <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header Welcome Card -->
            <div
                class="mb-8 p-8 rounded-3xl border border-outline-variant/30 backdrop-blur-md relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6"
                style="background: rgba(211, 228, 254, 0.45)"
            >
                <div>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-widest mb-3"
                    >
                        Supply Chain Partners
                    </span>
                    <h1
                        class="text-3xl font-bold tracking-tight text-on-surface font-headline-lg"
                        style="
                            font-family:
                                &quot;Plus Jakarta Sans&quot;, sans-serif;
                        "
                    >
                        Suppliers & Vendors
                    </h1>
                    <p class="text-on-surface-variant font-body-md mt-1">
                        Register, track, and manage your partner channels and
                        shipping vendors.
                    </p>
                </div>
                <div class="flex gap-3">
                    <button
                        @click="scrollToRegister"
                        class="bg-primary text-on-primary border border-transparent px-5 py-2.5 rounded-xl font-label-md text-label-md flex items-center gap-2 hover:bg-primary-container transition-all shadow-md"
                    >
                        <span class="material-symbols-outlined text-[18px]"
                            >add_circle</span
                        >
                        Register Supplier
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Stat 1: Total Suppliers -->
                <div
                    class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70"
                >
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary"
                        >
                            <span class="material-symbols-outlined text-[24px]"
                                >local_shipping</span
                            >
                        </div>
                        <span
                            class="text-[11px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full border border-primary/20"
                            >VENDORS</span
                        >
                    </div>
                    <p
                        class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant"
                    >
                        Registered Partners
                    </p>
                    <h3
                        class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1"
                        style="
                            font-family:
                                &quot;Plus Jakarta Sans&quot;, sans-serif;
                        "
                    >
                        {{ suppliers.length }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Active suppliers in your network
                    </p>
                </div>

                <div
                    class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70"
                >
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 bg-secondary/15 rounded-2xl flex items-center justify-center text-secondary"
                        >
                            <span class="material-symbols-outlined text-[24px]"
                                >contact_mail</span
                            >
                        </div>
                        <span
                            class="text-[11px] font-bold text-secondary bg-secondary/15 px-2 py-0.5 rounded-full border border-secondary/20"
                            >CONTACTS</span
                        >
                    </div>
                    <p
                        class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant"
                    >
                        Active Contacts
                    </p>
                    <h3
                        class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1"
                        style="
                            font-family:
                                &quot;Plus Jakarta Sans&quot;, sans-serif;
                        "
                    >
                        {{ activeContactsCount }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Vendors with valid email or phone
                    </p>
                </div>

                <div
                    class="card-hover p-6 rounded-3xl border border-outline-variant/40 backdrop-blur-md relative overflow-hidden transition-all bg-white/70"
                >
                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="w-12 h-12 bg-amber-100/60 rounded-2xl flex items-center justify-center text-amber-700"
                        >
                            <span class="material-symbols-outlined text-[24px]"
                                >location_on</span
                            >
                        </div>
                        <span
                            class="text-[11px] font-bold text-amber-700 bg-amber-100/50 px-2 py-0.5 rounded-full border border-amber-200"
                            >LOCATIONS</span
                        >
                    </div>
                    <p
                        class="text-[12px] font-bold uppercase tracking-wider text-on-surface-variant"
                    >
                        Geographic Coverage
                    </p>
                    <h3
                        class="text-3xl font-extrabold text-on-surface font-headline-lg mt-1"
                        style="
                            font-family:
                                &quot;Plus Jakarta Sans&quot;, sans-serif;
                        "
                    >
                        {{ locationsCount }}
                    </h3>
                    <p class="text-[11px] text-on-surface-variant mt-2">
                        Vendors with physical locations
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div
                    ref="registerCard"
                    class="lg:col-span-4 bg-white/60 backdrop-blur-md p-6 rounded-3xl border border-outline-variant/30 shadow-sm flex flex-col justify-between h-fit"
                >
                    <div>
                        <h4
                            class="font-headline-sm text-headline-sm text-on-surface font-extrabold mb-2"
                            style="
                                font-family:
                                    &quot;Plus Jakarta Sans&quot;, sans-serif;
                            "
                        >
                            Register Vendor
                        </h4>
                        <p class="text-xs text-on-surface-variant mb-6">
                            Create a profile for a new supply network partner.
                        </p>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label
                                    for="supplier_name"
                                    class="block text-xs font-bold uppercase text-on-surface-variant mb-1"
                                    >Supplier Name</label
                                >
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline/70 text-[20px]"
                                        >business</span
                                    >
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        id="supplier_name"
                                        placeholder="e.g. Acme Logistics"
                                        class="ps-10 block w-full rounded-xl border border-outline-variant/60 bg-white/50 text-on-surface placeholder:text-outline/50 focus:border-primary focus:ring-2 focus:ring-primary/10 sm:text-sm transition-all py-2.5"
                                        required
                                    />
                                </div>
                                <p
                                    v-if="form.errors.name"
                                    class="text-error text-xs mt-1"
                                >
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div>
                                <label
                                    for="supplier_email"
                                    class="block text-xs font-bold uppercase text-on-surface-variant mb-1"
                                    >Email Address</label
                                >
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline/70 text-[20px]"
                                        >mail</span
                                    >
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        id="supplier_email"
                                        placeholder="e.g. contact@acme.com"
                                        class="ps-10 block w-full rounded-xl border border-outline-variant/60 bg-white/50 text-on-surface placeholder:text-outline/50 focus:border-primary focus:ring-2 focus:ring-primary/10 sm:text-sm transition-all py-2.5"
                                    />
                                </div>
                                <p
                                    v-if="form.errors.email"
                                    class="text-error text-xs mt-1"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <div>
                                <label
                                    for="supplier_phone"
                                    class="block text-xs font-bold uppercase text-on-surface-variant mb-1"
                                    >Phone Number</label
                                >
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline/70 text-[20px]"
                                        >phone</span
                                    >
                                    <input
                                        v-model="form.phone"
                                        type="text"
                                        id="supplier_phone"
                                        placeholder="e.g. +1 (555) 019-2834"
                                        class="ps-10 block w-full rounded-xl border border-outline-variant/60 bg-white/50 text-on-surface placeholder:text-outline/50 focus:border-primary focus:ring-2 focus:ring-primary/10 sm:text-sm transition-all py-2.5"
                                    />
                                </div>
                                <p
                                    v-if="form.errors.phone"
                                    class="text-error text-xs mt-1"
                                >
                                    {{ form.errors.phone }}
                                </p>
                            </div>

                            <div>
                                <label
                                    for="supplier_address"
                                    class="block text-xs font-bold uppercase text-on-surface-variant mb-1"
                                    >Address / Location</label
                                >
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-3.5 top-4 text-outline/70 text-[20px]"
                                        >location_on</span
                                    >
                                    <textarea
                                        v-model="form.address"
                                        id="supplier_address"
                                        rows="3"
                                        placeholder="e.g. 100 Warehouse Way, Sector 4"
                                        class="ps-10 pt-3 block w-full rounded-xl border border-outline-variant/60 bg-white/50 text-on-surface placeholder:text-outline/50 focus:border-primary focus:ring-2 focus:ring-primary/10 sm:text-sm transition-all"
                                    ></textarea>
                                </div>
                                <p
                                    v-if="form.errors.address"
                                    class="text-error text-xs mt-1"
                                >
                                    {{ form.errors.address }}
                                </p>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full bg-primary text-on-primary py-3 px-4 rounded-xl font-bold text-sm shadow-md hover:bg-primary-container transition-all flex items-center justify-center gap-2 mt-2 disabled:opacity-50"
                            >
                                <span
                                    class="material-symbols-outlined text-[18px]"
                                    >save</span
                                >
                                Register Vendor
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Directory Table -->
                <div
                    class="lg:col-span-8 bg-white/60 backdrop-blur-md rounded-3xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col justify-between"
                >
                    <div>
                        <!-- Header with Search -->
                        <div
                            class="px-8 py-6 border-b border-outline-variant/30 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-surface-container-high/20"
                        >
                            <div>
                                <h4
                                    class="font-headline-sm text-headline-sm text-on-surface font-extrabold"
                                    style="
                                        font-family:
                                            &quot;Plus Jakarta Sans&quot;,
                                            sans-serif;
                                    "
                                >
                                    Supplier Directory
                                </h4>
                                <p
                                    class="text-xs text-on-surface-variant mt-0.5"
                                >
                                    List of active shipping channels and product
                                    suppliers.
                                </p>
                            </div>
                            <div class="relative w-full sm:w-72">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline/70 text-[18px]"
                                    >search</span
                                >
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Search vendors..."
                                    class="ps-9 pe-4 py-2 w-full rounded-xl border border-outline-variant/50 bg-white/50 text-on-surface placeholder:text-outline/50 focus:border-primary focus:ring-2 focus:ring-primary/10 sm:text-xs transition-all"
                                />
                            </div>
                        </div>

                        <!-- Data Table -->
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr
                                        class="border-b border-outline-variant/20 bg-surface-container-low/40"
                                    >
                                        <th
                                            class="px-8 py-4 font-label-md text-label-md text-outline"
                                        >
                                            VENDOR NAME
                                        </th>
                                        <th
                                            class="px-6 py-4 font-label-md text-label-md text-outline"
                                        >
                                            CONTACT DETAILS
                                        </th>
                                        <th
                                            class="px-6 py-4 font-label-md text-label-md text-outline"
                                        >
                                            PHYSICAL LOCATION
                                        </th>
                                        <th
                                            class="px-8 py-4 font-label-md text-label-md text-outline text-right"
                                        >
                                            ACTIONS
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-outline-variant/20"
                                >
                                    <tr
                                        v-for="supplier in filteredSuppliers"
                                        :key="supplier.id"
                                        class="hover:bg-surface-variant/25 transition-colors"
                                    >
                                        <td class="px-8 py-4">
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <!-- Avatar Badge -->
                                                <div
                                                    class="w-10 h-10 rounded-xl flex items-center justify-center font-bold border bg-gradient-to-br"
                                                    :class="
                                                        getAvatarClass(
                                                            supplier.name,
                                                        )
                                                    "
                                                >
                                                    {{
                                                        supplier.name
                                                            ? supplier.name
                                                                  .charAt(0)
                                                                  .toUpperCase()
                                                            : "S"
                                                    }}
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="font-semibold text-on-surface text-sm"
                                                        >{{
                                                            supplier.name
                                                        }}</span
                                                    >
                                                    <span
                                                        class="text-[11px] text-on-surface-variant"
                                                        >ID:
                                                        {{ supplier.id }}</span
                                                    >
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-sm text-on-surface-variant"
                                        >
                                            <div class="flex flex-col gap-1">
                                                <div
                                                    v-if="supplier.email"
                                                    class="flex items-center gap-1.5"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-[15px] text-primary/70"
                                                        >mail</span
                                                    >
                                                    <a
                                                        :href="`mailto:${supplier.email}`"
                                                        class="text-xs text-primary hover:underline"
                                                        >{{ supplier.email }}</a
                                                    >
                                                </div>
                                                <div
                                                    v-else
                                                    class="text-xs italic text-outline/50 flex items-center gap-1.5"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-[15px] text-outline/30"
                                                        >mail</span
                                                    >
                                                    No email registered
                                                </div>
                                                <div
                                                    v-if="supplier.phone"
                                                    class="flex items-center gap-1.5"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-[15px] text-secondary/80"
                                                        >phone</span
                                                    >
                                                    <a
                                                        :href="`tel:${supplier.phone}`"
                                                        class="text-xs text-on-surface hover:underline"
                                                        >{{ supplier.phone }}</a
                                                    >
                                                </div>
                                                <div
                                                    v-else
                                                    class="text-xs italic text-outline/50 flex items-center gap-1.5"
                                                >
                                                    <span
                                                        class="material-symbols-outlined text-[15px] text-outline/30"
                                                        >phone</span
                                                    >
                                                    No phone registered
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 text-xs text-on-surface-variant max-w-[200px] truncate"
                                        >
                                            <div
                                                class="flex items-center gap-1.5"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-[16px] text-outline/70"
                                                    >location_on</span
                                                >
                                                <span
                                                    :title="supplier.address"
                                                    >{{
                                                        supplier.address ||
                                                        "N/A"
                                                    }}</span
                                                >
                                            </div>
                                        </td>
                                        <td class="px-8 py-4 text-right">
                                            <button
                                                @click="
                                                    deleteSupplier(supplier.id)
                                                "
                                                class="w-8 h-8 rounded-lg flex items-center justify-center text-error bg-error-container/20 hover:bg-error-container/40 hover:text-error transition-colors ml-auto"
                                                title="Delete Supplier"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-[18px]"
                                                    >delete</span
                                                >
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="filteredSuppliers.length === 0">
                                        <td
                                            colspan="4"
                                            class="px-8 py-12 text-center text-on-surface-variant italic"
                                        >
                                            <div
                                                class="flex flex-col items-center justify-center gap-2"
                                            >
                                                <span
                                                    class="material-symbols-outlined text-[36px] text-outline/40"
                                                    >local_shipping</span
                                                >
                                                <span class="text-xs">
                                                    {{
                                                        searchQuery
                                                            ? "No suppliers match your search query."
                                                            : "No suppliers registered. Add your first supplier to begin!"
                                                    }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div
                        class="px-8 py-4 border-t border-outline-variant/20 bg-surface-container-low/20 text-center"
                    >
                        <span class="text-xs text-on-surface-variant"
                            >Showing {{ filteredSuppliers.length }} records.
                            Updated in real time.</span
                        >
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Card hover lift + glow */
.card-hover {
    transition:
        transform 0.35s ease,
        box-shadow 0.35s ease,
        border-color 0.35s ease;
}
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 36px rgba(53, 37, 205, 0.08);
    border-color: rgba(53, 37, 205, 0.25) !important;
}

/* Floating blobs */
.blob {
    animation: floatBlob 12s ease-in-out infinite;
}
.blob-a {
    animation-duration: 14s;
}
.blob-b {
    animation-duration: 10s;
    animation-delay: -3s;
}
@keyframes floatBlob {
    0%,
    100% {
        transform: translate(0, 0) scale(1);
    }
    33% {
        transform: translate(20px, -15px) scale(1.05);
    }
    66% {
        transform: translate(-15px, 20px) scale(0.96);
    }
}

@media (prefers-reduced-motion: reduce) {
    .blob,
    .card-hover {
        animation: none !important;
        transition: none !important;
    }
}
</style>
