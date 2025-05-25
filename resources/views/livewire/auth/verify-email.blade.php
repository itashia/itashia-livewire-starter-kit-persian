<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    /**
     * ارسال نوتیفیکیشن تأیید ایمیل به کاربر
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * خروج کاربر از سیستم
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="mt-4 flex flex-col gap-6">
    <flux:text class="text-center">
        {{ __('لطفاً با کلیک روی لینکی که برای شما ایمیل کرده‌ایم، ایمیل خود را تأیید کنید.') }}
    </flux:text>

    @if (session('status') == 'verification-link-sent')
        <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
            {{ __('لینک تأیید جدید به آدرس ایمیلی که در ثبت نام وارد کرده‌اید ارسال شد.') }}
        </flux:text>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <flux:button wire:click="sendVerification" variant="primary" class="w-full">
            {{ __('ارسال مجدد ایمیل تأیید') }}
        </flux:button>

        <flux:link class="text-sm cursor-pointer" wire:click="logout">
            {{ __('خروج') }}
        </flux:link>
    </div>
</div>