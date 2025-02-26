<div
    class="flex items-center flex-col bg-gradient-to-b from-[#ffb5ab] via-[#fff] to-[#ffb5ab] md:w-fit mx-5 md:mx-auto py-5 px-5 rounded-md">
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

        <tbody>
            {{ $body }}
        </tbody>
    </table>
    <div class="md:hidden text-left w-full">
        {{ $slot }}
    </div>
    <div class="flex flex-col md:flex-row items-center justify-between text-xs md:text-sm w-full pt-3">
        {{ $footer }}
    </div>

</div>

</div>
