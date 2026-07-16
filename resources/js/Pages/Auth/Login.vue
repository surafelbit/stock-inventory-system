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

        <div class="mb-stack-lg">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Sign in to your account
            </h2>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Manage your global inventory and logistics streams.
            </p>
        </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-stack-md">
            <!-- Email Field -->
            <div class="space-y-1 group">
                <label for="email" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                    Email Address
                </label>
                <input
                    id="email"
                    type="email"
                    class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="john@company.com"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="space-y-1 group">
                <label for="password" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                    Password
                </label>
                <input
                    id="password"
                    type="password"
                    class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember me & Forgot Password -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        name="remember"
                        v-model="form.remember"
                        class="mt-1 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary"
                    />
                    <span class="font-body-md text-body-md text-on-surface-variant">Remember me</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="font-body-md text-body-md text-primary hover:underline"
                >
                    Forgot your password?
                </Link>
            </div>

            <!-- Submit Button -->
            <button
                class="w-full h-12 bg-primary-container text-white font-label-md text-[14px] font-bold rounded shadow-sm hover:opacity-90 active:scale-[0.98] transition-all border-t border-white/20 flex items-center justify-center gap-2"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Sign In
            </button>
        </form>

        <!-- Social Divider and Buttons -->
        <div class="mt-8 text-center">
            <div class="relative flex items-center mb-8">
                <div class="flex-grow border-t border-outline-variant"></div>
                <span class="flex-shrink mx-4 font-label-md text-label-md text-outline">OR CONTINUE WITH</span>
                <div class="flex-grow border-t border-outline-variant"></div>
            </div>

            <div class="grid grid-cols-2 gap-stack-md mb-8">
                <button type="button" class="flex items-center justify-center gap-2 h-11 border border-outline-variant rounded hover:bg-surface-container-low transition-colors">
                    <img alt="Google" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAsOJnu5mYFykmWlo8ncSOHRic_M-RCzneS_GjBKSp53QXK7iSw-Z8KamhnmBCa40z6kSmG9doDuroCuxT4PASHVzT3pUJHktJ8tA9xSwTHPtDPwDg6AgnPpDa3J2JX-Rxm_hwB60PHvgvLwx8I2LJMLZDuqV_KP6S4npKvWF4pAdGFL4DLu-bXjlVWF9ZtwVBuFcfZjAKlTAuUc4xr3IRlqDQgfbBQ7hLKaqf1TrNDLPtWgDl6ZgzE">
                    <span class="font-label-md text-label-md text-on-surface">Google</span>
                </button>
                <button type="button" class="flex items-center justify-center gap-2 h-11 border border-outline-variant rounded hover:bg-surface-container-low transition-colors">
                    <img alt="Microsoft" class="w-5 h-5" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCFXpmmfMS2w3gFfRjMWsJDW4enb0afUcvz8afvSWbebQFHspXKv2wz82-cwm0Due7KJFra2ftMKeLi-iz31gLfcetxTh-aUZiI2sWGpQAjG2hTyjNtT5BUspxuI-H_uB6Dfaql9FsFIzz6DEL7RuJtm_wXYZZr1Jfg6BOaI30BlP7gaE8ty37e7ARsVOX6twLB2zLlyWEC-SccTL63ir9OJclQiPQyK15M4uPASz7O3YebHRFlfDEP">
                    <span class="font-label-md text-label-md text-on-surface">Microsoft</span>
                </button>
            </div>

            <p class="font-body-md text-body-md text-on-surface-variant">
                Don't have an account? 
                <Link :href="route('register')" class="text-primary font-bold hover:underline">
                    Create account instead
                </Link>
            </p>
        </div>
    </GuestLayout>
</template>
