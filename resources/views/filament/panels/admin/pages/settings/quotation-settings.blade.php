<x-filament-panels::page>
    <form
        wire:submit.prevent="save"
        class="space-y-6"
    >
        {{-- Form --}}
        <div>
            {{ $this->form }}
        </div>
    </form>
</x-filament-panels::page>
