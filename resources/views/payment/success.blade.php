<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #0f0f1e;
            color: #ffffff;
            font-family: 'Space Grotesk', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="text-center p-8 bg-gray-800 rounded-xl shadow-2xl max-w-md">
        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold mb-4">Payment Successful!</h1>
        <p class="text-gray-300 mb-6">Your payment has been processed successfully. You can now proceed with your withdrawal.</p>
        <a href="{{ route('profile') }}" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 rounded-lg font-medium transition duration-300">
            Back to Profile
        </a>
    </div>
</body>
</html>