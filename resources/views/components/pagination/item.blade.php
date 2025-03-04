<button
    class="@if ($key == $current) max-w-8 text-[#fff] bg-[#a12c2f] @else text-[#a12c2f] @endif  w-full min-w-7 min-h-7 border-[#a12c2f] border-r text-center cursor-pointer items-center"
    onclick="handleAJAX({ page:{{ $key }} })">
    {{ $key }}
</button>
