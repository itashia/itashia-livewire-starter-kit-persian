<x-layouts.app :title="__('داشبورد')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- پیام خوش آمدگویی پیشرفته -->
        <div class="mb-6 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-center shadow-lg dark:from-blue-700 dark:to-indigo-800">
            <div class="mx-auto max-w-2xl">
                <h2 class="text-2xl font-bold text-white drop-shadow-md">به دنیای لاراول فارسی خوش آمدید!</h2>
                <p class="mt-3 text-blue-100">
                    راهکاری جامع برای توسعه سریع و حرفه‌ای برنامه‌های لاراولی
                </p>
                <div class="mt-4 rounded-lg bg-white/10 p-3 backdrop-blur-sm">
                    <p class="text-sm font-medium text-white">
                        برای مدیریت حرفه‌ای‌تر پروژه‌های لاراولی خود از ابزار CLI ما استفاده کنید:
                    </p>
                    <a href="https://github.com/itashia/laris-cli" target="_blank" 
                       class="mt-2 inline-block rounded-full bg-white px-4 py-2 text-sm font-bold text-blue-600 shadow-md transition hover:bg-blue-50 hover:shadow-lg">
                        Laris CLI - ابزار مدیریت لاراول فارسی
                    </a>
                </div>
                <p class="mt-4 text-xs text-blue-200">
                    آخرین بروزرسانی: {{ \Morilog\Jalali\Jalalian::now()->format('Y/m/d') }}
                </p>
            </div>
        </div>

        <!-- محتوای اصلی داشبورد -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>