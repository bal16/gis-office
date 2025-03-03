@php
    $next ??= null;
    $prev ??= null;
    // dd($last);
@endphp


<div class="flex bg-[#fff] shadow-lg rounded-md mt-4 md:mt-0 px-2 ajax-content">
    <x-pagination.nav value="{{ $prev }}">Previous</x-pagination.nav>
    @if ($last > 5)
        <!-- First two pages -->
        @for ($i = 1; $i <= 2; $i++)
            <x-pagination.item key="{{ $i }}" current="{{ $current }}" />
        @endfor

        <!-- Dots if needed -->
        @if ($current > 4)
            <x-pagination.dot />
        @endif

        <!-- Middle page -->
        @if ($current > 2 && $current < $last - 1)
            <x-pagination.item key="{{ $current }}" current="{{ $current }}" />
        @endif

        <!-- Dots if needed -->
        @if ($current < $last - 3)
            <x-pagination.dot />
        @endif

        <!-- Last two pages -->
        @for ($i = $last - 1; $i <= $last; $i++)
            <x-pagination.item key="{{ $i }}" current="{{ $current }}" />
        @endfor
    @else
        @for ($i = 1; $i <= $last; $i++)
            <x-pagination.item key="{{ $i }}" current="{{ $current }}" />
        @endfor
    @endif
    <x-pagination.nav value="{{ $next }}">Next</x-pagination.nav>
</div>
