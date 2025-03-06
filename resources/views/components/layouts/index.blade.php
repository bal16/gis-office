<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'GIS-Offices') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative font-raleway antialiased bg-gray-100">
    <button onclick="topFunction()" id="toTop" title="Go to top"
        class="hidden fixed bottom-5 right-5 z-99 text-2 cursor-pointer bg-primary text-white p-3 rounded-full shadow-xl hover:bg-white hover:text-primary transition-colors duration-250">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor"
            version="1.1" id="Capa_1" viewBox="0 0 462.847 462.847" xml:space="preserve" class="size-5">
            <g>
                <g>
                    <path
                        d="M257.261,88.679c-1.635-2.034-3.428-3.405-5.281-4.258c-5.586-4.25-13.649-5.319-20.253,0.794    C156.973,154.431,77.815,218.764,4.669,289.735c-4.961,4.81-5.558,10.542-3.702,15.463c0.363,2.828,1.485,5.683,3.702,8.333    c17.61,21.018,36.122,41.223,55.467,60.667c8.325,8.363,19.296,4.219,24.138-3.494c48.362-40.649,96.253-87.062,144.664-127.66    c46.263,46.052,98.673,90.438,146.659,134.622c5.383,4.951,11.73,5.149,16.92,2.772c4.936-0.376,9.455-3.361,12.781-7.662    c15.615-20.216,32.077-39.746,49.231-58.677c7.814-4.763,12.126-15.884,3.793-24.358    C391.827,222.103,316.886,162.896,257.261,88.679z M386.993,346.025c-47.073-42.157-97.574-85.62-141.874-130.824    c-2.306-2.356-4.834-3.656-7.373-4.248c-5.578-3.786-13.348-4.674-19.883,0.779c-49.129,41.015-97.627,87.976-146.558,129.219    c-12.002-12.446-23.577-25.293-34.901-38.364c66.443-63.515,137.316-122.143,205.155-184.145    c55.127,66.511,122.171,121.356,183.386,182.017C411.859,315.293,399.251,330.502,386.993,346.025z" />
                </g>
            </g>
        </svg>
    </button>
    {{ $slot }}
</body>

</html>
