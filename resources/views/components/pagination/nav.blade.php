<button
    class=" px-2 min-w-20 cursor-pointer text-center disabled:text-gray-500 @if ($slot == 'Previous') border-primary border-r @endif min-h-7 items-center disabled:cursor-not-allowed"
    @if ($disabled) disabled @endif onclick="handleAJAX({ page:{{ $value }} })">
    {{ $slot }}
</button>
