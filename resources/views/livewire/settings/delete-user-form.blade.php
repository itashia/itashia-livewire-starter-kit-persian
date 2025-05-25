<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * حذف کاربر احراز هویت شده فعلی
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('حذف حساب کاربری') }}</flux:heading>
        <flux:subheading>{{ __('حساب کاربری و تمام منابع آن را حذف کنید') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('حذف حساب کاربری') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('آیا مطمئن هستید می‌خواهید حساب کاربری خود را حذف کنید؟') }}</flux:heading>

                <flux:subheading>
                    {{ __('پس از حذف حساب کاربری، تمام منابع و داده‌های آن به طور دائمی حذف خواهند شد. لطفاً رمز عبور خود را وارد کنید تا تأیید کنید می‌خواهید حساب کاربری خود را به طور دائمی حذف کنید.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('رمز عبور')" type="password" />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('انصراف') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('حذف حساب کاربری') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>