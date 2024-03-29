@php
use Filament\Support\Facades\FilamentView;

$heading = $this->getHeading();
$filters = $this->getFilters();
@endphp

<x-filament-widgets::widget>
    <x-filament::section :heading="$heading">
        @if ($filters)
        <x-slot name="headerEnd">
            <x-filament::input.wrapper inline-prefix wire:target="filter" class="w-max sm:-my-2">
                <x-filament::input.select inline-prefix wire:model.live="filter">
                    @foreach ($filters as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                    @endforeach
                </x-filament::input.select>
            </x-filament::input.wrapper>
        </x-slot>
        @endif
        <div class="flex flex-col gap-2">
            @if($this->getData()->isNotEmpty())
            @foreach ($this->getData() as $data)
            <div class="flex flex-col border-b border-[0.5px]">
                <span>Name: {{ $data->name }}</span>
                <span>Email: {{ $data->email }}</span>
            </div>
            @endforeach
            @else
            <span>No more data</span>
            @endif
        </div>

    </x-filament::section>
</x-filament-widgets::widget>