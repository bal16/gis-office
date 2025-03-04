<x-layouts>
    @assets
        <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
        <script src="{{ asset('vendor/leaflet-routing/leaflet-routing-machine.js') }}"></script>
    @endassets
    @assets
        <link href="{{ asset('vendor/leaflet/leaflet.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/leaflet-routing/leaflet-routing-machine.css') }}" rel="stylesheet" />
    @endassets
    <x-layouts.header />

    <main class="bg-linear-to-b from-tertiary from-0% to-white to-30% text-center pb-15 md:max-w-[1280px] mx-auto">
        <x-hero />
        <x-table.layout>
            <x-slot:header>
                <x-search />
            </x-slot:header>
            <x-slot:body>
                @foreach ($offices as $office)
                    <x-table.item key="{{ $office->id }}" number="{{ $office->id }}"
                        longitude="{{ $office->longitude }}" latitude="{{ $office->latitude }}"
                        image="{{ $office->image }}">
                        {{ $office->name }}
                        <br />
                        {{ $office->district_name }}
                    </x-table.item>
                @endforeach
            </x-slot:body>
            @foreach ($offices as $office)
                <x-table.item-mobile key="{{ $office->id }}" longitude="{{ $office->longitude }}"
                    latitude="{{ $office->latitude }}" image="{{ $office->image }}">
                    {{ "$office->name, $office->district_name" }}
                </x-table.item-mobile>
            @endforeach
            <x-slot:footer>
                <div>
                    <small class="ajax-content">Showing {{ $offices->count() }} of {{ $offices->total() }}
                        entries</small>
                </div>
                <x-pagination current="{{ $offices->currentPage() }}" last="{{ $offices->lastPage() }}"
                    next="{{ $offices->currentPage() + 1 }}" prev="{{ $offices->currentPage() - 1 }}" />
            </x-slot:footer>
        </x-table.layout>
    </main>
    <x-layouts.footer />

    <script src="{{ asset('js/script.js') }}"></script>
</x-layouts>
