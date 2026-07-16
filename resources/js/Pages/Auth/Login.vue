<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log In" />

        <!-- Form Heading -->
        <div class="mb-8 text-left">
            <h2 class="font-headline-md text-headline-md font-extrabold text-on-surface mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Welcome Back
            </h2>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Sign in to manage your inventory network.
            </p>
        </div>

        <!-- Session Status -->
        <div v-if="status" class="mb-6 p-4 rounded-xl bg-secondary/10 text-secondary text-sm font-semibold border border-secondary/20">
            {{ status }}
        </div>

        <!-- Login Form -->
        <form @submit.prevent="submit" class="space-y-5">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-semibold text-on-surface/90 tracking-wide mb-1.5">
                    Email Address
                </label>
                <div class="relative">
                    <input
                        id="email"
                        type="email"
                        class="block w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-surface/40 text-on-surface placeholder:text-outline/60 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 outline-none text-[15px]"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="name@company.com"
                    />
                </div>
                <InputError class="mt-1.5 text-xs text-error font-medium" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-sm font-semibold text-on-surface/90 tracking-wide mb-1.5">
                    Password
                </label>
                <div class="relative">
                    <input
                        id="password"
                        type="password"
                        class="block w-full px-4 py-3 rounded-xl border border-outline-variant/60 bg-surface/40 text-on-surface placeholder:text-outline/60 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-200 outline-none text-[15px]"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                </div>
                <InputError class="mt-1.5 text-xs text-error font-medium" :message="form.errors.password" />
            </div>

            <!-- Remember Me & Forgot Password Row -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center cursor-pointer select-none">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        v-model="form.remember"
                        class="rounded border-outline-variant/60 text-primary shadow-sm focus:ring-primary/20 focus:ring-offset-0 h-4.5 w-4.5 bg-surface/40 transition-colors"
                    />
                    <span class="ms-2.5 text-sm font-medium text-on-surface-variant">Remember me</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm font-semibold text-primary hover:text-on-primary-fixed-variant hover:underline transition-colors"
                >
                    Forgot password?
                </Link>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button
                    type="submit"
                    class="btn-shimmer bg-primary text-on-primary w-full py-3.5 px-6 rounded-xl font-headline-sm font-semibold shadow-lg shadow-primary/15 hover:shadow-primary/25 active:scale-[0.98] hover:-translate-y-0.5 transition-all text-center flex items-center justify-center gap-2"
                    :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                    :disabled="form.processing"
                >
                    <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' 1;">login</span>
                    Log In
                </button>
            </div>
        </form>

        <!-- Footer / Demo link -->
        <div class="mt-8 pt-6 border-t border-outline-variant/30 text-center text-sm text-on-surface-variant">
            Don't have an account?
            <Link :href="route('register')" class="font-bold text-primary hover:underline ml-1">
                Request Access
            </Link>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* Shimmer sweep on primary buttons */
.btn-shimmer { position: relative; overflow: hidden; }
.btn-shimmer::after {
    content: '';
    position: absolute;
    top: 0; left: -75%;
    width: 50%; height: 100%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
    transform: skewX(-20deg);
    transition: left 0.6s ease;
}
.btn-shimmer:hover::after { left: 125%; }
</style>
