<button
    class="@if ($key == $current) text-[#fff] bg-[#a12c2f] @else text-[#a12c2f] @endif  w-full border-[#a12c2f] border-1 px-2 cursor-pointer"
    onclick="handleAJAX({ page:{{ $key }} })">
    {{ $key }}
</button>
