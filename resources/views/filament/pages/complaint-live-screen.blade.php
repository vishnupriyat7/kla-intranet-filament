<x-filament-panels::page>
    <!-- Use iframe to embed Bootstrap view without conflicting with Filament's Tailwind CSS -->
    <div style="height: calc(100vh - 65px); margin: -1rem;" class="bg-gray-50 dark:bg-gray-900 overflow-hidden">
        <iframe src="{{ url('/complaintregister/live-iframe') }}" class="w-full h-full border-0"></iframe>
    </div>
</x-filament-panels::page>
