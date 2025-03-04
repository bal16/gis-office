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
        <span class="pt-2 {{ "jarak-$number" }}">menghitung jarak...</span>
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
