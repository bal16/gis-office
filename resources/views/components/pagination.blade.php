@php
    $next ??= null;
    $prev ??= null;
@endphp

<!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.

  Plugins:
    - @tailwindcss/forms
-->

<div class="flex bg-[#fff] shadow-lg rounded-md mt-4 md:mt-0 px-2">
    <button class="w-full pr-3" @if ($prev == null) disabled @endif>Previous
    </button>
    <button class="text-[#fff] bg-[#a12c2f] w-full border-[#a12c2f] border-1 px-2">
        {{ $current }}
    </button>
    <button class="w-full pl-3" @if ($next == null) disabled @endif>
        Next
    </button>
</div>
