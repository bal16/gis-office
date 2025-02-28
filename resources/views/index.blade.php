<x-layouts>
    @assets
        <script src="{{ asset('leaflet/leaflet.js') }}"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@3.2.5/dist/leaflet-routing-machine.js"></script>
    @endassets
    @assets
        <link href="{{ asset('leaflet/leaflet.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.5/dist/leaflet-routing-machine.css" />
    @endassets
    @assets
        <script src="{{ asset('js/calcDist.js') }}"></script>
    @endassets
    <x-layouts.header />
    <div id="map" />

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
                    {{ "$office->name, $office->district_name" }},
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

</x-layouts>
