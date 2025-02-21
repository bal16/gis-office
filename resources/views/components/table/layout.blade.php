<section class='w-1/2'>
    <!--
  Heads up! 👋

  This component comes with some `rtl` classes. Please remove them if they are not needed in your project.
-->

<div class="rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto rounded-t-lg">
        <div class="flex items-center justify-end rounded-b-lg border-t border-gray-200 px-4 py-2 dark:border-gray-700">
            {{$header}}
        </div>
      <table
        class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm dark:divide-gray-700 dark:bg-gray-900"
      >
        <thead class="ltr:text-left rtl:text-right">
          <tr>
            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white">
              Nomor
            </th>
            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white">
              Nama Kantor
            </th>
            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white">
              Link Map
            </th>
            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white">
              Foto
            </th>
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
        {{$slot}}
        </tbody>
      </table>
    </div>
    <div class="flex items-center justify-between rounded-b-lg border-t border-gray-200 px-4 py-2 dark:border-gray-700">
        {{$footer}}
    </div>

  </div>
</section>
