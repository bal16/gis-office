<button
    class=" w-full px-2 active:cursor-pointer text-center disabled:bg-gray-400 disabled:text-gray-500"
    @if ($value == null) disabled @endif
    onclick="handleAJAX({ page:{{ $value }} })">
    {{ $slot }}
</button>
