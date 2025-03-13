<button
    class="page-nav @if ($key == $current) max-w-8 text-white bg-primary @else text-primary @endif  w-full min-w-7 min-h-7 border-primary border-r text-center cursor-pointer items-center"
    data-target="{{ $key }}">
    {{ $key }}
</button>
