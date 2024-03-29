@php
use Filament\Support\Facades\FilamentView;

$heading = $this->getHeading();
$filters = $this->getFilters();
$data = $this->getData();
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
            @foreach ($this->getData() as $data)
            <div class="flex justify-between border-b border-[0.5px]">
                <div class="flex flex-col">
                    <span>{{ $data['name'] }}</span>
                    <span class="text-xs">{{ $data['qty'] }} Product</span>
                </div>
                <div class="flex">
                    <span>Rp. {{ number_format($data['total'], 0, ",", ".")  }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>