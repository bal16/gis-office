<tr>
    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white">
      {{ $number }}
    </td>
    <td class="px-4 py-2 whitespace-nowrap text-gray-700 dark:text-gray-200">{{ $name }}</td>
    <td class="px-4 py-2 whitespace-nowrap text-gray-700 dark:text-gray-200">
        <a
            class="inline-block rounded-sm bg-indigo-600 px-8 py-3 text-sm font-medium text-white transition hover:scale-110 hover:shadow-xl focus:ring-3 focus:outline-hidden"
            href="{{ "https://www.google.com/maps/dir/Current+Location/$longitude,$latitude" }}"
            target="_blank"
        >
            Buka Map
        </a>
        <br/>
        <span id="{{"jarak-$number"}}">menghitung jarak...</span>
      {{-- {{ $longitude }}, {{ $latitude }} --}}
    </td>
    <td class="px-4 py-2 whitespace-nowrap text-gray-700 dark:text-gray-200">
        <img src="{{ asset("storage/".$image) }}" width="100" height="100" class="hover:scale-110 transition-transform" />
    </td>
</tr>

