@if (config('filament.layout.footer.should_show_logo'))
    <div class="flex items-center justify-center filament-footer text-center">
        <a
            href="{{ route('index') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="dark:text-gray-300 text-gray-400 hover:text-primary-500 transition"
        >
            {{ config('app.name') }} v{{ config('app.version', '1.0.0') }}
        </a>
        &nbsp;-&nbsp;
        <a
            href="https://aquadic.com"
            target="_blank"
            rel="noopener noreferrer"
            class="dark:text-gray-300 text-gray-400 hover:text-primary-500 transition"
        >
            {{ __('admin.made_by', ['company' => __('admin.aquadic')]) }}
        </a>
    </div>
@endif
