<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('ظاهر')" :subheading="__('تنظیمات ظاهری حساب کاربری خود را به‌روزرسانی کنید')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('روز') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('شب') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('سیستم') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>