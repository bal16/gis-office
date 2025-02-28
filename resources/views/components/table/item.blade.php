<tr class="bg-[#fff] shadow-lg">
    <td class="rounded-l-xl pl-3 pr-5">
        {{ $number }}
    </td>
    <td class="px-5 text-sm max-w-100 min-w-100">{{ $slot }}</td>
    <td class="px-5 text-sm">
        <a class="bg-[#a12c2f] text-[#fff] px-3 py-1 rounded-full"
            href="{{ "https://www.google.com/maps/dir/Current+Location/$latitude,$longitude" }}" target="_blank">
            Buka Map
        </a>
        <br />
        <span id="{{ "jarak-$number" }}" class="pt-2">menghitung jarak...</span>
        {{-- {{ $longitude }}, {{ $latitude }} --}}
    </td>
    <td class="rounded-r-xl p-5">
        <img src="{{ asset('storage/' . $image) }}" class="rounded-xl h-60 w-60 object-cover" />
    </td>
    {{-- <script>
        calcDistance([{{ $latitude }}, {{ $longitude }}], [51.505, -0.09], "jarak-{{ $number }}");
    </script> --}}
</tr>
