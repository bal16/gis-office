<div class="bg-white rounded-xl px-5 py-5 mb-3 shadow-lg text-center">
    <ul>
        <li class="flex font-bold gap-1 pb-5 justify-center">

            <div>{{ $slot }}</div>
        </li>
        <li class="flex gap-1 pb-2 justify-center">

            <div>
                <a href="{{ "https://www.google.com/maps/dir/Current+Location/$longitude,$latitude" }}" target="_blank"
                    class="bg-primary text-white px-3 py-1 rounded-full">Buka Map</a>
            </div>
        </li>
        <li class="flex gap-1 pb-2 justify-center">

            <div class="flex inline-text {{ "jarak-$key" }}"> <svg class="mr-3 -ml-1 size-5 animate-spin text-black"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>Menghitung Jarak...</div>
        </li>
        <li>
            <div class="flex items-center justify-center">
                <img class="rounded-xl h-45 w-80 object-cover" src="{{ asset('storage/' . $image) }}"
                    alt="{{ "gambar-$key" }}" />
            </div>
        </li>
    </ul>
</div>
