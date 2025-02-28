@php
    $next ??= null;
    $prev ??= null;
    // dd($last);
@endphp

<!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.

  Plugins:
    - @tailwindcss/forms
-->

<div class="flex bg-[#fff] shadow-lg rounded-md mt-4 md:mt-0 px-2">
    <button class="w-full pr-3" @if ($prev == null) disabled @endif>
        Previous
    </button>
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


    <button class="w-full pl-3" @if ($next == null) disabled @endif>
        Next
    </button>
</div>
