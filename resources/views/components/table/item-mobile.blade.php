<div class="bg-[#fff] rounded-xl px-5 py-5 mb-3 shadow-lg">
    <ul>
        <li class="flex gap-1 pb-2">
            <div class="font-bold">Nama Kantor:</div>
            <div>{{ $slot }}</div>
        </li>
        <li class="flex gap-1 pb-2">
            <div class="font-bold">Link Map:</div>
            <div>
                <a href="{{ "https://www.google.com/maps/dir/Current+Location/$longitude,$latitude" }}"
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
                    src="{{ asset('storage/' . $image) }}" alt="" />
            </div>
        </li>
    </ul>
</div>
