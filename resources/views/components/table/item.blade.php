<tr class="bg-white shadow-lg">
    <td class="rounded-l-xl pl-3 pr-5">
        {{ $number }}
    </td>
    <td class="px-5 text-sm max-w-100 min-w-100">{{ $slot }}</td>
    <td class="px-5 text-sm">
        <a class="bg-primary text-white px-3 py-1 rounded-full"
            href="{{ "https://www.google.com/maps/dir/Current+Location/$latitude,$longitude" }}" target="_blank">
            Buka Map
        </a>
        <br />
        <span class="flex inline-text pt-2 {{ "jarak-$number" }}"><svg class="mr-3 -ml-1 size-5 animate-spin text-black"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>Menghitung Jarak...</span>
    </td>
    <td class="rounded-r-xl p-5">
        <img src="{{ asset('storage/' . $image) }}" class="rounded-xl h-60 w-60 object-cover" />
    </td>
    <script>
        //get location from local storage
        setTimeout(() => {
            calcDistance(JSON.parse(localStorage.getItem("currentLocation")), [{{ $latitude }},
                {{ $longitude }}
            ], "jarak-{{ $number }}");
        }, 2000)
    </script>
</tr>
