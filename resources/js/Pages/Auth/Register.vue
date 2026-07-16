<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    company_name: "",
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="mb-stack-lg">
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2" style="font-family: 'Plus Jakarta Sans', sans-serif;">
                Create your account
            </h2>
            <p class="font-body-md text-body-md text-on-surface-variant">
                Start your 14-day premium trial today. No credit card required.
            </p>
        </div>

        <form @submit.prevent="submit" class="space-y-stack-md">
            <!-- Full Name & Company Name Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                <div class="space-y-1 group">
                    <label for="name" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                        Full Name
                    </label>
                    <input
                        id="name"
                        type="text"
                        class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                        placeholder="John Doe"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
                </div>
                <div class="space-y-1 group">
                    <label for="company_name" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                        Company Name
                    </label>
                    <input
                        id="company_name"
                        type="text"
                        class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                        placeholder="Acme Logistics"
                        v-model="form.company_name"
                        required
                        autocomplete="company_name"
                    />
                    <InputError class="mt-1" :message="form.errors.company_name" />
                </div>
            </div>

            <!-- Email Field -->
            <div class="space-y-1 group">
                <label for="email" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                    Email Address
                </label>
                <input
                    id="email"
                    type="email"
                    class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                    placeholder="john@company.com"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-1" :message="form.errors.email" />
            </div>

            <!-- Password & Confirm Password Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-stack-md">
                <div class="space-y-1 group">
                    <label for="password" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                        placeholder="••••••••"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-1" :message="form.errors.password" />
                </div>
                <div class="space-y-1 group">
                    <label for="password_confirmation" class="font-label-md text-label-md text-on-surface-variant group-focus-within:text-primary transition-colors duration-200">
                        Confirm Password
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        class="w-full h-11 px-4 border border-outline-variant rounded bg-white text-body-md focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all outline-none"
                        placeholder="••••••••"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-1" :message="form.errors.password_confirmation" />
                </div>
            </div>

            <!-- Agreement Checkbox -->
            <div class="pt-stack-sm">
                <label class="flex items-start gap-3 cursor-pointer select-none">
                    <input
                        type="checkbox"
                        class="mt-1 w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary"
                        required
                    />
                    <span class="font-body-md text-body-md text-on-surface-variant">
                        I agree to the <a class="text-primary hover:underline font-semibold" href="#">Terms of Service</a> and <a class="text-primary hover:underline font-semibold" href="#">Privacy Policy</a>.
                    </span>
                </label>
            </div>

            <!-- Submit Button -->
            <button
                class="w-full h-12 bg-primary-container text-white font-label-md text-[14px] font-bold rounded shadow-sm hover:opacity-90 active:scale-[0.98] transition-all border-t border-white/20 flex items-center justify-center gap-2"
                :class="{ 'opacity-50 cursor-not-allowed': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Create Account
            </button>
        </form>

        <!-- Social login divider and buttons -->
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
                Already have an account? 
                <Link :href="route('login')" class="text-primary font-bold hover:underline">
                    Sign in instead
                </Link>
            </p>
        </div>
    </GuestLayout>
</template>
