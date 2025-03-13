<x-layouts>
    <x-layouts.header />

    <main class="bg-linear-to-b from-tertiary from-0% to-white to-30% text-center pb-15 md:max-w-[1280px] mx-auto">
        <x-hero />
        <x-table.layout>
            <x-slot:header>
                <x-search />
            </x-slot:header>
            <x-slot:body>
                <tr class="w-full" id="not-found" @if ($offices->count() > 0) style="display: none;" @endif>
                    <td colspan="4" class="bg-white rounded-2xl shadow-xl text-center px-100 py-3">Tidak ada data.
                    </td>
                </tr>
                @foreach ($offices as $office)
                    <x-table.item key="{{ $office->id }}" number="{{ $office->id }}"
                        longitude="{{ $office->longitude }}" latitude="{{ $office->latitude }}"
                        image="{{ $office->image }}">
                        <span class="font-bold">{{ $office->name }}</span>
                        <br />
                        {{ $office->is_district ? '' : $office->district_name }}
                    </x-table.item>
                @endforeach
            </x-slot:body>
            @foreach ($offices as $office)
                <x-table.item-mobile key="{{ $office->id }}" longitude="{{ $office->longitude }}"
                    latitude="{{ $office->latitude }}" image="{{ $office->image }}">
                    <span class="font-bold">{{ $office->name }}</span>
                    {{ $office->is_district ? '' : $office->district_name }}
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

    @vite(['resources/js/script.js'])
</x-layouts>
