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

    <main class="bg-linear-to-b from-[#ffb5ab] from-0% to-[#fff] to-30% text-center pb-15 md:max-w-[1280px] mx-auto">
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
                    <small>Showing {{ $offices->perpage() }} of {{ $offices->total() }} entries</small>
                </div>
                <x-pagination current="{{ $offices->currentPage() }}" last="{{ $offices->lastPage() }}"
                    next="{{ $offices->nextPageUrl() }}" prev="{{ $offices->previousPageUrl() }}" />
            </x-slot:footer>
        </x-table.layout>
    </main>
    <x-layouts.footer />

    <script src="{{ asset('js/calcDist.js') }}"></script>
</x-layouts>
