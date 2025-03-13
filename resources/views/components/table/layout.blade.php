<div
    class="flex items-center flex-col bg-radial-[at_-50%_50%] from-teritary from-57% to-quaternary md:w-fit mx-5 md:mx-auto py-5 px-5 rounded-2xl shadow-2xl">
    {{ $header }}

    <table class="border-separate border-spacing-2 border-spacing-x-0 text-left max-w-500 hidden md:block">
        <thead>
            <tr>
                <td class="pr-3">No.</td>
                <td class="pr-3">Nama Kantor</td>
                <td class="pr-3">Link Map</td>
                <td class="pr-3">Foto</td>
            </tr>
        </thead>
        <tbody class="ajax-content">
            {{ $body }}
        </tbody>
    </table>
    <div class="md:hidden text-left w-full ajax-content">
        {{ $slot }}
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between text-xs md:text-sm w-full pt-3">
        {{ $footer }}
    </div>
</div>
