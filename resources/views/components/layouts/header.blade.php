<header class="flex items-center justify-between px-5 py-2 md:px-20 md:py-5 md:max-w-[1280px] mx-auto bg-gray-50 shadow-sm sticky top-0 z-10">
    <img src="{{ asset('image/logo.png') }}" alt="" class="h-5 md:h-10" />
    <div class="font-bold text-xs md:text-sm">
        <a href="{{ route('filament.admin.auth.register') }}">SIGNUP</a>
        |
        <a href="{{ route('filament.admin.auth.login') }}">LOGIN</a>
    </div>
</header>
