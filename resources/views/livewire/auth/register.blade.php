<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * پردازش درخواست ثبت نام
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('ایجاد حساب کاربری')" 
        :description="__('برای ایجاد حساب کاربری، اطلاعات خود را وارد کنید')" 
    />

    <!-- وضعیت نشست -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- نام -->
        <flux:input
            wire:model="name"
            :label="__('نام')"
            type="text"
            required
            autofocus
            autocomplete="name"
            :placeholder="__('نام کامل')"
        />

        <!-- آدرس ایمیل -->
        <flux:input
            wire:model="email"
            :label="__('آدرس ایمیل')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

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

        <!-- تأیید رمز عبور -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('تأیید رمز عبور')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('تأیید رمز عبور')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('ایجاد حساب') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('قبلاً حساب کاربری دارید؟') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('ورود') }}</flux:link>
    </div>
</div>