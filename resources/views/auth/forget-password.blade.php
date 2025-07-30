<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>

    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-200">
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-6 bg-gray-800 rounded-lg shadow-md">
        <h1 class="mb-6 text-2xl font-semibold text-center">Forgot Password</h1>

        @if (session('success'))
            <div class="p-4 mb-4 text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-300">Email Address</label>
                <input
                        id="email"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        class="w-full p-3 text-gray-100 bg-gray-700 border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Send Password Reset Link
            </button>
        </form>
    </div>
</div>
</body>
</html>
