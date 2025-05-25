<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * مقداردهی اولیه کامپوننت
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * بازنشانی رمز عبور کاربر
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // در اینجا سعی می‌کنیم رمز عبور کاربر را بازنشانی کنیم
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // اگر رمز عبور با موفقیت بازنشانی شد
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header 
        :title="__('بازنشانی رمز عبور')" 
        :description="__('لطفاً رمز عبور جدید خود را وارد کنید')" 
    />

    <!-- وضعیت نشست -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- ایمیل -->
        <flux:input
            wire:model="email"
            :label="__('ایمیل')"
            type="email"
            required
            autocomplete="email"
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
                {{ __('بازنشانی رمز عبور') }}
            </flux:button>
        </div>
    </form>
</div>