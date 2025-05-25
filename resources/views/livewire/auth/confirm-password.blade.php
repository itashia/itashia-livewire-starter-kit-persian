<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    /**
     * تایید رمز عبور کاربر فعلی
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('رمز عبور ارائه شده نادرست است.'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header
        :title="__('تایید رمز عبور')"
        :description="__('این بخش امنی از برنامه است. لطفاً قبل از ادامه، رمز عبور خود را تأیید کنید.')"
    />

    <!-- وضعیت نشست -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="confirmPassword" class="flex flex-col gap-6">
        <!-- رمز عبور -->
        <flux:input
            wire:model="password"
            :label="__('رمز عبور')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('رمز عبور')"
            viewable
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('تایید') }}</flux:button>
    </form>
</div>