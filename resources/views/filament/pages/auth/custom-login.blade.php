<div class="flex min-h-screen">
    <!-- Left side: Live Screen -->
    <div wire:ignore class="hidden lg:block lg:w-2/3 bg-gray-50 border-r border-gray-200 relative overflow-hidden" style="background-color: #f0f2f5;">
        <iframe src="{{ url('/complaintregister/live-iframe') }}" class="w-full h-full border-0"></iframe>
    </div>
    
    <!-- Right side: Login Form -->
    <div class="w-full lg:w-1/3 flex items-center justify-center p-8 bg-white dark:bg-gray-900">
        <div class="w-full max-w-md space-y-8">
            <x-filament-panels::header.simple
                :heading="$this->getHeading()"
                :logo="$this->hasLogo()"
                :subheading="$this->getSubHeading()"
            />

            <x-filament-panels::form id="form" wire:submit="authenticate">
                {{ $this->form }}

                <x-filament-panels::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </x-filament-panels::form>
        </div>
    </div>
</div>
