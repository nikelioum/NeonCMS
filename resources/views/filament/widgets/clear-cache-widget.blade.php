<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-lg font-semibold">Shortcuts</h2>
        <div class="mt-4 flex" style="padding-top: 20px;">
            <x-filament::button wire:click="clearConfigCache" color="warning" style="margin-right:20px;">Clear Config Cache</x-filament::button>
            <x-filament::button wire:click="clearViewsCache" color="warning" style="margin-right:20px;">Clear Views Cache</x-filament::button>
            <x-filament::button wire:click="deleteActivityLogs" color="warning">Delete Activity Logs</x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
