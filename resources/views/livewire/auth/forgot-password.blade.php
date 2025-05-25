<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * ارسال لینک بازنشانی رمز عبور به آدرس ایمیل ارائه شده
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('اگر حساب کاربری وجود داشته باشد، لینک بازنشانی ارسال خواهد شد.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('فراموشی رمز عبور')" 
        :description="__('ایمیل خود را وارد کنید تا لینک بازنشانی رمز عبور را دریافت کنید')" 
    />

    <!-- وضعیت نشست -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- آدرس ایمیل -->
        <flux:input
            wire:model="email"
            :label="__('آدرس ایمیل')"
            type="email"
            required
            autofocus
            placeholder="email@example.com"
            viewable
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('ارسال لینک بازنشانی رمز عبور') }}</flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        {{ __('یا بازگشت به') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('ورود') }}</flux:link>
    </div>
</div>