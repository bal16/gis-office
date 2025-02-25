<x-layouts>
    <x-layouts.header />
    <main class="bg-linear-to-b from-[#ffb5ab] from-0% to-[#fff] to-30% text-center pb-15 md:max-w-[1280px] mx-auto">
        <x-hero />
        <x-table.layout>
            <x-slot:header>
                <x-search />
            </x-slot:header>
            @foreach ($offices as $office)
                <x-table.item key="{{ $office->id }}" number="{{ $office->id }}" longitude="{{ $office->longitude }}"
                    latitude="{{ $office->latitude }}" image="{{ $office->image }}">
                    <x-slot:name>
                        {{ $office->name }}
                        <br />
                        {{ $office->district_name }}
                    </x-slot:name>
                </x-table.item>
            @endforeach
            <div class="md:hidden text-left w-full">
                @foreach ($offices as $office)
                    <div class="bg-[#fff] rounded-xl px-5 py-5 mb-3 shadow-lg">
                        <ul>
                            <li class="flex gap-1 pb-2">
                                <div class="font-bold">Nama Kantor:</div>
                                <div>{{ $office->name }},
                                    {{ $office->district_name }}</div>
                            </li>
                            <li class="flex gap-1 pb-2">
                                <div class="font-bold">Link Map:</div>
                                <div>
                                    <a href="{{ "https://www.google.com/maps/dir/Current+Location/$office->longitude,$office->latitude" }}"
                                        class="bg-[#a12c2f] text-[#fff] px-3 py-1 rounded-full">Buka Map</a><br />
                                </div>
                            </li>
                            <li class="flex gap-1 pb-2">
                                <div class="font-bold">Jarak:</div>
                                <div>Menghitung Jarak</div>
                            </li>
                            <li>
                                <div class="font-bold pb-2">Foto:</div>
                                <div class="flex items-center justify-center">
                                    <img class="rounded-xl h-45 w-80 object-cover"
                                        src="{{ asset('storage/' . $office->image) }}" alt="" />
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
            <x-slot:footer>
                {{-- @php
                    dd($offices);
                @endphp --}}
                <div>
                    <small>Showing {{ $offices->perpage() }} of {{ $offices->total() }} entries</small>
                </div>
                <x-pagination current="{{ $offices->currentPage() }}" next="{{ $offices->nextPageUrl() }}"
                    prev="{{ $offices->previousPageUrl() }}" />
            </x-slot:footer>
        </x-table.layout>
    </main>
    <x-layouts.footer />
</x-layouts>
