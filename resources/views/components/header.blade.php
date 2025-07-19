<header>
    <nav class="bg-gray-800 border-gray-200 px-4 lg:px-6 py-2.5 ">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="/" class="flex items-center">
                <span class=" text-red-600 hover:text-gray-100 self-center text-xl font-semibold whitespace-nowrap ">KerjaStat.id</span>
            </a>
            <div class="flex items-center lg:order-2">
                @auth
                <a href="/dashboard"
                    class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">
                    Dashboard
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="text-gray-700 hover:bg-gray-700 hover:text-white font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 focus:outline-none">
                        Logout
                    </button>
                </form>
                @else
                <a href="/login"
                    class="text-gray-700 hover:bg-gray-700 hover:text-white font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 focus:outline-none">
                    Log in
                </a>
                @endauth

                <button data-collapse-toggle="mobile-menu-2" type="button"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="mobile-menu-2" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="z-[1001] bg-gray-800 hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="/"
                            class="block py-2 pr-4 pl-3 {{ request()-> routeIs('home') ? 'text-white' : 'text-gray-700' }} hover:text-white rounded bg-primary-700 lg:bg-transparent lg:text-primary-700 lg:p-0 "
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="/maps"
                            class="block py-2 pr-4 pl-3 {{ request()->is('maps') ? 'text-white' : 'text-gray-700' }} border-b border-gray-100 hover:bg-gray-50 hover:text-white lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0">Peta</a>
                    </li>
                    <li>
                        <a href="/data"
                            class="block py-2 pr-4 pl-3 {{ request()->is('data') ? 'text-white' : 'text-gray-700' }} border-b border-gray-100 hover:bg-gray-50 hover:text-white lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0">Data</a>
                    </li>
                    <li>
                        <a href="/hasil-analisis"
                            class="block py-2 pr-4 pl-3 {{ request()->is('hasil-analisis') ? 'text-white' : 'text-gray-700' }} border-b border-gray-100 hover:bg-gray-50 hover:text-white lg:hover:bg-transparent lg:border-0 lg:hover:text-primary-700 lg:p-0">Hasil Analisis</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>