<div class="bg-[#fff] rounded-xl px-5 py-5 mb-3 shadow-lg text-center">
    <ul>
        <li class="flex font-bold gap-1 pb-5 justify-center">
            
            <div>{{ $slot }}</div>
        </li>
        <li class="flex gap-1 pb-2 justify-center">
            
            <div>
                <a href="{{ "https://www.google.com/maps/dir/Current+Location/$longitude,$latitude" }}"
                    class="bg-[#a12c2f] text-[#fff] px-3 py-1 rounded-full">Buka Map</a><br />
            </div>
        </li>
        <li class="flex gap-1 pb-2 justify-center">
            
            <div>Menghitung Jarak</div>
        </li>
        <li>
            <div class="flex items-center justify-center">
                <img class="rounded-xl h-45 w-80 object-cover"
                    src="{{ asset('storage/' . $image) }}" alt="" />
            </div>
        </li>
    </ul>
</div>
