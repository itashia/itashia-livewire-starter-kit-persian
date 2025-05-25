<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * مدیریت درخواست احراز هویت
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('اطلاعات وارد شده صحیح نیست'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

    /**
     * اطمینان از محدود نبودن درخواست احراز هویت
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('تعداد تلاش های شما بیش از حد مجاز است. لطفاً پس از :seconds ثانیه مجدداً تلاش کنید', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * دریافت کلید محدودیت نرخ احراز هویت
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('ورود به حساب کاربری')" 
        :description="__('ایمیل و رمز عبور خود را وارد کنید')" 
    />

    <!-- وضعیت نشست -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- آدرس ایمیل -->
        <flux:input
            wire:model="email"
            :label="__('آدرس ایمیل')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- رمز عبور -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('رمز عبور')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('رمز عبور')"
                viewable
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute start-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                </flux:link>
            @endif
        </div>

        <!-- مرا به خاطر بسپار -->
        <flux:checkbox wire:model="remember" :label="__('مرا به خاطر بسپار')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('ورود') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('حساب کاربری ندارید؟') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('ثبت نام') }}</flux:link>
        </div>
    @endif
</div>