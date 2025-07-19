<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <section class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow dark:border dark:bg-gray-800 dark:border-gray-700">

            <!-- Logo / Judul -->
            <div class="flex justify-center mt-6">
                <a href="/" class="text-red-600 hover:text-gray-100 text-xl font-semibold whitespace-nowrap">
                    KerjaStat.id
                </a>
            </div>

            <!-- Form Box -->
            <div class="p-6 space-y-6">
                <h1 class="text-xl font-bold leading-tight text-gray-900 md:text-2xl dark:text-white text-center">
                    Sign in to your account
                </h1>

                @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
                @endif

                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <input type="text" name="name" id="name" placeholder="username"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full mt-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Sign in
                    </button>
                </form>
            </div>

            <div class=" flex w-full mb-4">
                <a href="/" class=" underline text-blue-600 w-full text-center">Kembali Ke Halaman Utama.</a>
            </div>
        </div>
    </section>
</body>

</html>