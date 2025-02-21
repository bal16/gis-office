@php
    $next ??= null;
    $prev??= null;
@endphp

<!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.

  Plugins:
    - @tailwindcss/forms
-->

<div class="inline-flex items-center justify-end rounded-sm bg-blue-600 py-1 text-white">
    <button
        class="inline-flex size-8 items-center justify-center rtl:rotate-180"
        @if($prev == null) disabled @endif
    >
      <span class="sr-only">Prev Page</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
        <path
          fill-rule="evenodd"
          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </button>

    <span class="h-4 w-px bg-white/25" aria-hidden="true"></span>

    <div>
      <label for="PaginationPage" class="sr-only">Page</label>

      <input
        type="number"
        class="h-8 w-12 rounded-sm border-none bg-transparent p-0 text-center text-xs font-medium [-moz-appearance:_textfield] focus:ring-white focus:outline-hidden focus:ring-inset [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none"
        min="1"
        value="{{ $current }}"
        id="PaginationPage"
      />
    </div>

    <span class="h-4 w-px bg-white/25"></span>

    <button
        class="inline-flex size-8 items-center justify-center rtl:rotate-180"
        @if($next == null) disabled @endif
    >
      <span class="sr-only">Next Page</span>
      <svg xmlns="http://www.w3.org/2000/svg" class="size-3" viewBox="0 0 20 20" fill="currentColor">
        <path
          fill-rule="evenodd"
          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </button>
  </div>
