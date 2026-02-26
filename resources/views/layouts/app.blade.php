<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>

{{-- Chart.js CDN đặt ở layout --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Cho phép component push script --}}
@stack('scripts')