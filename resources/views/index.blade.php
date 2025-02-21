<x-layouts>
    <x-layouts.header />
    <h1 class="text-3xl" >Hello</h1>
    <x-hero />
    <x-table.layout>
        <x-slot:header >
            <x-search />
        </x-slot:header>
        @foreach ($offices as $office)
            <x-table.item
                key="{{ $office->id }}"
                number="{{ $office->id }}"
                longitude="{{ $office->longitude }}"
                latitude="{{ $office->latitude }}"
                image="{{ $office->image }}"
                >
                <x-slot:name>
                    {{ $office->name }}
                    <br/>
                    {{ $office->district_name }}
                </x-slot:name>
            </x-table.item>
        @endforeach
        <x-slot:footer >
            {{-- @php
                dd($offices);
            @endphp --}}
            <div>
                <small>showing {{ $offices->perpage() }} of {{ $offices->total() }} records</small>
            </div>
            <x-pagination current="{{ $offices->currentPage() }}" next="{{ $offices->nextPageUrl() }}" prev="{{ $offices->previousPageUrl() }}"/>
        </x-slot:footer>
    </x-table.layout>
    <x-layouts.footer />
</x-layouts>
