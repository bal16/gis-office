<button
    class=" px-2 min-w-20 cursor-pointer text-center disabled:text-gray-500 @if ($slot == 'Previous') border-[#a12c2f] border-r @endif min-h-7 items-center disabled:cursor-not-allowed"
    @if ($disabled) disabled @endif onclick="handleAJAX({ page:{{ $value }} })">
    {{ $slot }}
</button>
