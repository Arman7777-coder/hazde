<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoonFunds | Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #0f0f1e;
            color: #ffffff;
            overflow-x: hidden;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1a103c 0%, #2b1e5a 100%);
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .glow-text {
            color: #ffffff;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn-primary {
            background: linear-gradient(90deg, #8A2BE2 0%, #4B0082 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #9B30FF 0%, #5B0099 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(138, 43, 226, 0.4);
        }

        .btn-success {
            background: linear-gradient(90deg, #00C853 0%, #009624 100%);
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(90deg, #00E676 0%, #00C853 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 200, 83, 0.4);
        }

        .pending-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0.6;
            }
            100% {
                opacity: 1;
            }
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
            100% {
                transform: translateY(0px);
            }
        }

        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 0) 100%
            );
            pointer-events: none;
            transform: rotate(30deg);
            animation: shine 6s infinite linear;
        }

        @keyframes shine {
            0% {
                left: -100%;
                top: -100%;
            }
            100% {
                left: 100%;
                top: 100%;
            }
        }

        .sidebar-item {
            transition: all 0.3s ease;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background-color: rgba(255, 152, 0, 0.2);
            color: #FFB74D;
            border: 1px solid rgba(255, 152, 0, 0.5);
        }

        .planet-bg {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #8A2BE2, #1a103c);
            filter: blur(60px);
            opacity: 0.15;
            z-index: -1;
            top: -250px;
            right: -250px;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: white;
            border-radius: 50%;
            opacity: 0.8;
            animation: twinkle 5s infinite;
        }

        @keyframes twinkle {
            0% { opacity: 0.2; }
            50% { opacity: 0.8; }
            100% { opacity: 0.2; }
        }

        .modal {
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: linear-gradient(135deg, #1a103c 0%, #2b1e5a 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(138, 43, 226, 0.5);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(138, 43, 226, 0.8);
        }

        /* Progress bar */
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #8A2BE2 0%, #4B0082 100%);
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-logo {
            height: 20px;
            margin-left: 10px;
        }

        /* SVG styles */
        .svg-icon {
            display: inline-block;
            vertical-align: middle;
        }

        .svg-icon path,
        .svg-icon circle {
            transition: all 0.3s ease;
        }

        .svg-icon.glow path,
        .svg-icon.glow circle {
            filter: drop-shadow(0 0 3px rgba(138, 43, 226, 0.6));
        }

        .svg-purple path,
        .svg-purple circle {
            fill: #8A2BE2;
        }

        .svg-blue path,
        .svg-blue circle {
            fill: #4169E1;
        }

        .svg-moon {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-content {
            background-color: #1a1a2e;
            margin: 15% auto;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal.show {
            display: block;
            opacity: 1;
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .contact-item {
            transition: all 0.2s ease;
        }

        .contact-item:hover {
            background-color: rgba(168, 132, 243, 0.1);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Stars Background -->
    <div id="stars-container"></div>
    <div class="planet-bg"></div>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-opacity-20 bg-black border-r border-gray-800 hidden md:block animate__animated animate__fadeInLeft">
            <div class="p-6">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                        <svg class="svg-icon w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="white" d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20c-4.42,0-8-3.58-8-8
                            c0-4.42,3.58-8,8-8s8,3.58,8,8C20,16.42,16.42,20,12,20z M11,7h2v6h-2V7z M11,15h2v2h-2V15z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">MoonFunds</span>
                </div>
            </div>
            <div class="mt-6">
                <div class="sidebar-item flex items-center space-x-3 px-6 py-3 bg-purple-900 bg-opacity-30 border-l-4 border-purple-500">
                    <i class="fas fa-home text-purple-400"></i>
                    <span>Dashboard</span>
                </div>
                <div class="sidebar-item flex items-center space-x-3 px-6 py-3">
                    <i class="fas fa-history text-gray-400"></i>
                    <span class="text-gray-300">Transaction History</span>
                </div>
                <div class="sidebar-item flex items-center space-x-3 px-6 py-3">
                    <i class="fas fa-wallet text-gray-400"></i>
                    <span class="text-gray-300">My Wallet</span>
                </div>
                <div class="sidebar-item flex items-center space-x-3 px-6 py-3">
                    <i class="fas fa-exchange-alt text-gray-400"></i>
                    <span class="text-gray-300">Market</span>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>


                <div class="sidebar-item flex items-center space-x-3 px-6 py-3">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt text-gray-400"></i>
                        <span class="text-gray-300">  Logout</span>
                    </a>
                </div>

            </div>
            <div class="px-6 mt-auto absolute bottom-6 left-0 right-0">
                <div class="card p-4 bg-purple-900 bg-opacity-20">
                    <div class="flex items-center space-x-3 mb-2">
                        <svg class="svg-icon w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#A884F3" d="M12,1C5.93,1,1,5.93,1,12c0,1.56,0.33,3.03,0.89,4.38L1,23l6.62-0.89C8.97,22.67,10.44,23,12,23
                            c6.07,0,11-4.93,11-11S18.07,1,12,1z M12,21c-1.42,0-2.74-0.36-3.9-0.99l-4.1,0.55l0.55-4.1C3.36,14.74,3,13.42,3,12
                            c0-4.97,4.03-9,9-9c4.97,0,9,4.03,9,9C21,16.97,16.97,21,12,21z M12,6.5c-2.48,0-4.5,2.02-4.5,4.5h2c0-1.38,1.12-2.5,2.5-2.5
                            s2.5,1.12,2.5,2.5c0,1.38-1.12,2.5-2.5,2.5c-0.57,0-1.08-0.19-1.5-0.51v1.51h2V16h-4v-3.5C7.91,12.18,9,10.48,9,8.5
                            c0-1.66,1.34-3,3-3s3,1.34,3,3C15,14.5,12,14.5,12,6.5z"/>
                        </svg>
                        <span class="font-medium">Need Help?</span>
                    </div>
                    <p class="text-sm text-gray-300">Our support team is available 24/7</p>
                    <button  id="contactBtn"  class="btn-primary w-full py-2 rounded-lg mt-3 text-sm">Contact Support</button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" class="hidden fixed inset-0 z-40 bg-gray-900 bg-opacity-95 text-white p-6 space-y-6 md:hidden">
            <!-- Close Button -->
            <button id="close-mobile-menu" class="absolute top-4 right-6 text-white text-3xl font-bold">&times;</button>

            <!-- Menu Links -->
            <nav class="mt-16 text-center text-xl space-y-4">
                <a href="#withdraw" class="block hover:text-yellow-400">Withdraw Funds</a>
                <a href="#paygas" class="block hover:text-yellow-400">Pay Gas Fee</a>
                <a href="#contact" class="block hover:text-yellow-400">Contact Us</a>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Mobile Header -->
                            <div class="md:hidden flex justify-between items-center p-4 border-b border-gray-800">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                        <svg class="svg-icon w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="white" d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20c-4.42,0-8-3.58-8-8
                            c0-4.42,3.58-8,8-8s8,3.58,8,8C20,16.42,16.42,20,12,20z M11,7h2v6h-2V7z M11,15h2v2h-2V15z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold">MoonFunds</span>
                </div>
                <button id="mobile-menu-button" class="text-gray-300">
                    <svg class="svg-icon w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="currentColor" d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"/>
                    </svg>
                </button>
            </div>

            <!-- Main Content Area -->
            <div class="p-6">
                <!-- Adding Moon SVG Animation -->
                <div class="absolute top-10 right-10 opacity-30 hidden lg:block">
                    <svg class="svg-icon svg-moon w-24 h-24" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="50" r="40" fill="#1a103c" />
                        <circle cx="50" cy="50" r="35" fill="#2b1e5a" />
                        <circle cx="25" cy="30" r="8" fill="#3b2c6a" />
                        <circle cx="65" cy="20" r="5" fill="#3b2c6a" />
                        <circle cx="75" cy="60" r="7" fill="#3b2c6a" />
                        <circle cx="35" cy="70" r="6" fill="#3b2c6a" />
                    </svg>
                </div>

                <!-- Welcome Header Section -->
                <div class="gradient-bg p-6 rounded-xl mb-8 animate__animated animate__fadeIn">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold glow-text mb-2">Welcome back, {{$user->name}}</h1>
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-8 text-gray-300">
                                <div class="flex items-center">
                                    <i class="fas fa-tag mr-2 text-purple-400"></i>
                                    <span>Allocation ID: <span class="text-white">MF-398204</span></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check mr-2 text-purple-400"></i>
                                    <span>Approved: <span class="text-white">{{$user->created_at}}</span></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-wallet mr-2 text-purple-400"></i>
                                    <span>Wallet: <span class="text-white"> {{ substr($user->wallet_address, 0, 5) }}...{{ substr($user->wallet_address, -3) }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Dashboard Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Allocation Block -->
                    <div class="lg:col-span-2 card p-6 relative overflow-hidden animate__animated animate__fadeIn animate__delay-1s">
                        <div class="shine-effect"></div>
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
                            <div>
                                <h2 class="text-xl font-bold mb-1">Your Approved Allocation:</h2>
                                <div class="text-4xl font-bold text-purple-300 floating">${{$user->request_amount}}</div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <div class="status-badge status-pending pending-pulse">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending Smart Contract Activation
                                </div>
                            </div>
                        </div>
                        <div class="mb-6">
                            <div class="text-sm mb-1">Allocation Status:</div>
                            <div class="progress-bar">
                                <div class="progress-bar-fill" style="width: 50%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>Approved</span>
                                <span>Contract Activation</span>
                                <span>Funds Ready</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-400 italic mb-2">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            This allocation is valid for 24 hours. Confirm now to avoid expiration.
                        </p>
                        <div class="flex justify-end">
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Valid until:</div>
                                <div class="text-sm font-medium">{{ $user->created_at->addDay()->format('Y-m-d H:i:s') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Gas Fee Block -->
                    <div class="card p-6 animate__animated animate__fadeIn animate__delay-2s">
                        <div class="mb-6">
                            <h2 class="text-xl font-bold">Gas Fee Confirmation</h2>
                            <p class="text-gray-300 text-sm mt-2">
                                In order to activate your contract and release funds to your wallet, please confirm the network transaction fee.
                            </p>
                        </div>
                        <div class="bg-blue-900 bg-opacity-20 border border-blue-800 rounded-lg p-4 mb-6">
                            <div class="flex items-center text-blue-300 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span class="font-medium">Transaction Details</span>
                            </div>
                            <div class="text-sm text-gray-300 space-y-2">
                                <div class="flex justify-between">
                                    <span>Gas Fee:</span>
                                    <span class="text-white">$15</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Estimated Time:</span>
                                    <span class="text-white">~2 minutes</span>
                                </div>
                            </div>
                        </div>
                        @if($isPaid)
                            <button id="withdraw" class="btn-primary w-full py-3 rounded-lg font-medium">
                                Withdraw
                            </button>
                        @else

                        <button id="pay-gas-fee" class="btn-primary w-full py-3 rounded-lg font-medium">
                            Pay GAS Fee ($15)
                        </button>
                        @endif
                        <div class="flex items-center justify-center mt-3">
                            <span class="text-xs text-gray-400">Powered by</span>
                            <div class="logo-container ml-2">
                                <svg class="svg-icon svg-blue w-16 h-5" viewBox="0 0 120 30" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#4169E1" d="M8,5 C6.34,5 5,6.34 5,8 L5,22 C5,23.66 6.34,25 8,25 L112,25 C113.66,25 115,23.66 115,22 L115,8 C115,6.34 113.66,5 112,5 L8,5 Z M8,7 L112,7 C112.55,7 113,7.45 113,8 L113,22 C113,22.55 112.55,23 112,23 L8,23 C7.45,23 7,22.55 7,22 L7,8 C7,7.45 7.45,7 8,7 Z"/>
                                    <path fill="#4169E1" d="M13,10 L13,20 L20,20 L20,17 L16,17 L16,10 L13,10 Z"/>
                                    <circle fill="#4169E1" cx="22" cy="11.5" r="1.5"/>
                                    <circle fill="#4169E1" cx="22" cy="18.5" r="1.5"/>
                                    <path fill="#4169E1" d="M30,10 L27,10 L27,20 L30,20 L30,10 Z"/>
                                    <path fill="#4169E1" d="M40,10 L37,10 L37,20 L40,20 L40,16 L43,20 L47,20 L43,15 L47,10 L43,10 L40,14 L40,10 Z"/>
                                    <path fill="#4169E1" d="M57,10 L54,10 L54,20 L57,20 L57,10 Z"/>
                                    <path fill="#4169E1" d="M67,10 L60,10 L60,20 L67,20 L67,17 L63,17 L63,16 L67,16 L67,13 L63,13 L63,12 L67,12 L67,10 Z"/>
                                    <path fill="#4169E1" d="M77,10 L74,10 L74,17 C74,18.1 73.1,19 72,19 C70.9,19 70,18.1 70,17 L70,10 L67,10 L67,17 C67,19.76 69.24,22 72,22 C74.76,22 77,19.76 77,17 L77,10 Z"/>
                                    <path fill="#4169E1" d="M88,10 L85,10 L85,16 C85,17.66 83.66,19 82,19 C80.34,19 79,17.66 79,16 L79,10 L76,10 L76,16 C76,19.31 78.69,22 82,22 C85.31,22 88,19.31 88,16 L88,10 Z"/>
                                    <path fill="#4169E1" d="M98,10 L90,10 L90,12 L93,12 L93,20 L96,20 L96,12 L98,12 L98,10 Z"/>
                                    <path fill="#4169E1" d="M108,20 L108,18 L104,18 L104,16 L108,16 L108,14 L104,14 L104,12 L108,12 L108,10 L101,10 L101,20 L108,20 Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Overview -->
{{--                    <div class="lg:col-span-3 card p-6 animate__animated animate__fadeIn animate__delay-3s">--}}
{{--                        <h2 class="text-xl font-bold mb-4">Recent Activity</h2>--}}
{{--                        <div class="overflow-x-auto">--}}
{{--                            <table class="w-full">--}}
{{--                                <thead>--}}
{{--                                    <tr class="text-left text-gray-400 text-sm">--}}
{{--                                        <th class="pb-3">Event</th>--}}
{{--                                        <th class="pb-3">Date</th>--}}
{{--                                        <th class="pb-3">Status</th>--}}
{{--                                        <th class="pb-3">Details</th>--}}
{{--                                    </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody class="text-sm">--}}
{{--                                    <tr class="border-b border-gray-800">--}}
{{--                                        <td class="py-3">--}}
{{--                                            <div class="flex items-center">--}}
{{--                                                <div class="w-8 h-8 rounded-full bg-purple-800 flex items-center justify-center mr-3">--}}
{{--                                                    <svg class="svg-icon w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                        <path fill="#C9A0FF" d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20c-4.42,0-8-3.58-8-8--}}
{{--                                                        c0-4.42,3.58-8,8-8s8,3.58,8,8C20,16.42,16.42,20,12,20z M9.29,16.29L5.7,12.7c-0.39-0.39-0.39-1.02,0-1.41--}}
{{--                                                        c0.39-0.39,1.02-0.39,1.41,0L10,14.17l6.88-6.88c0.39-0.39,1.02-0.39,1.41,0s0.39,1.02,0,1.41l-7.59,7.59--}}
{{--                                                        C10.32,16.68,9.68,16.68,9.29,16.29z"/>--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <span>Allocation Approved</span>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3">July 15, 2025 - 10:23 AM</td>--}}
{{--                                        <td class="py-3">--}}
{{--                                            <span class="px-2 py-1 bg-green-900 bg-opacity-20 text-green-400 rounded-full text-xs">--}}
{{--                                                Completed--}}
{{--                                            </span>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3 text-right">--}}
{{--                                            <button class="text-purple-400 hover:text-purple-300">--}}
{{--                                                <i class="fas fa-external-link-alt"></i>--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr class="border-b border-gray-800">--}}
{{--                                        <td class="py-3">--}}
{{--                                            <div class="flex items-center">--}}
{{--                                                <div class="w-8 h-8 rounded-full bg-blue-800 flex items-center justify-center mr-3">--}}
{{--                                                    <svg class="svg-icon w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                        <path fill="#90CAF9" d="M11.99,2C6.47,2,2,6.48,2,12s4.47,10,9.99,10C17.52,22,22,17.52,22,12S17.52,2,11.99,2z M12,20--}}
{{--                                                        c-4.42,0-8-3.58-8-8s3.58-8,8-8s8,3.58,8,8S16.42,20,12,20z M12.5,7H11v6l5.25,3.15l0.75-1.23l-4.5-2.67V7z"/>--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <span>Contract Activation</span>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3">--</td>--}}
{{--                                        <td class="py-3">--}}
{{--                                            <span class="px-2 py-1 bg-yellow-900 bg-opacity-20 text-yellow-400 rounded-full text-xs">--}}
{{--                                                Pending--}}
{{--                                            </span>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3 text-right">--}}
{{--                                            <button class="text-purple-400 hover:text-purple-300">--}}
{{--                                                <i class="fas fa-external-link-alt"></i>--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td class="py-3">--}}
{{--                                            <div class="flex items-center">--}}
{{--                                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center mr-3">--}}
{{--                                                    <svg class="svg-icon w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                        <path fill="#A9A9A9" d="M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M16.54,15.85--}}
{{--                                                        c0.29,0.29,0.29,0.77,0,1.06c-0.15,0.15-0.34,0.22-0.53,0.22s-0.38-0.07-0.53-0.22L12,13.41l-3.48,3.48--}}
{{--                                                        c-0.15,0.15-0.34,0.22-0.53,0.22s-0.38-0.07-0.53-0.22c-0.29-0.29-0.29-0.77,0-1.06L10.94,12L7.47,8.53--}}
{{--                                                        c-0.29-0.29-0.29-0.77,0-1.06c0.29-0.29,0.77-0.29,1.06,0L12,10.94l3.48-3.48c0.29-0.29,0.77-0.29,1.06,0--}}
{{--                                                        c0.29,0.29,0.29,0.77,0,1.06L13.06,12L16.54,15.85z"/>--}}
{{--                                                        <circle fill="#A9A9A9" cx="7" cy="8" r="1"/>--}}
{{--                                                        <circle fill="#A9A9A9" cx="17" cy="8" r="1"/>--}}
{{--                                                        <circle fill="#A9A9A9" cx="12" cy="20" r="1"/>--}}
{{--                                                        <circle fill="#A9A9A9" cx="7" cy="16" r="1"/>--}}
{{--                                                        <circle fill="#A9A9A9" cx="17" cy="16" r="1"/>--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <span>Fund Release</span>--}}
{{--                                            </div>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3">--</td>--}}
{{--                                        <td class="py-3">--}}
{{--                                            <span class="px-2 py-1 bg-gray-800 text-gray-400 rounded-full text-xs">--}}
{{--                                                Waiting--}}
{{--                                            </span>--}}
{{--                                        </td>--}}
{{--                                        <td class="py-3 text-right">--}}
{{--                                            <button class="text-purple-400 hover:text-purple-300">--}}
{{--                                                <i class="fas fa-external-link-alt"></i>--}}
{{--                                            </button>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Modal for Post-Payment -->
    <div id="withdraw-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden modal">
        <div class="modal-content rounded-xl p-8 max-w-md w-full animate__animated animate__zoomIn">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-yellow-600 bg-opacity-30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="svg-icon w-12 h-12" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#FFC107" d="M12,2L1,21h22L12,2z M12,6l7.53,13H4.47L12,6z M11,10v4h2v-4H11z M11,16v2h2v-2H11z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Manual Review Required</h3>
                <p class="text-gray-300">
                    Your wallet requires manual review before funds can be released.
                </p>
                <p class="text-gray-300 mb-4">
                    For security reasons, please contact our admin to complete the withdrawal process.
                </p>
                <div class="card p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <svg class="svg-icon w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#4FC3F7" d="M9.78,18.65L10.06,14.42L17.74,7.5C18.08,7.19 17.67,7.04 17.22,7.31L7.74,13.3L3.64,12C2.76,11.75 2.75,11.14 3.84,10.7L19.81,4.54C20.54,4.21 21.24,4.72 20.96,5.84L18.24,18.65C18.05,19.56 17.5,19.78 16.74,19.36L12.6,16.3L10.61,18.23C10.38,18.46 10.19,18.65 9.78,18.65Z"/>
                        </svg>
                        <span class="font-medium">Telegram:</span>
                        <a href="#" class="text-blue-400 ml-2">@MoonFundsSupport</a>
                    </div>
                    <div class="flex items-center">
                        <svg class="svg-icon w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="#A884F3" d="M20,4H4C2.9,4,2,4.9,2,6v12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V6C22,4.9,21.1,4,20,4z M20,8l-8,5L4,8V6l8,5l8-5V8z"/>
                        </svg>
                        <span class="font-medium">Email:</span>
                        <a href="#" class="text-purple-400 ml-2">support@moonfunds.site</a>
                    </div>
                </div>
                <button class="btn-primary w-full py-3 rounded-lg font-medium">
                    Withdraw Funds (Manual Review Required)
                </button>
                <button id="close-modal" class="mt-4 text-gray-400 hover:text-white text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
    <div id="contactModal" class="modal">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-purple-300">Contact MoonFunds Support</h2>
                <button id="closeModal" class="text-gray-400 hover:text-white text-2xl focus:outline-none">&times;</button>
            </div>

            <div class="space-y-4">
                <div class="contact-item p-3 rounded-lg border border-purple-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center bg-purple-800 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.78 18.65l.28-4.23 7.68-6.92c.34-.31-.07-.46-.52-.19L7.74 13.3 3.64 12c-.88-.25-.89-.86.2-1.3l15.97-6.16c.73-.33 1.43.18 1.15 1.3l-2.72 12.81c-.19.91-.74 1.13-1.5.71L12.6 16.3l-1.99 1.93c-.23.23-.42.42-.83.42z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-purple-300">Telegram</h3>
                            <p class="text-gray-400 text-sm">@Moonfundssupport</p>
                        </div>
                    </div>
                </div>

                <div class="contact-item p-3 rounded-lg border border-purple-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 flex items-center justify-center bg-purple-800 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-purple-300">Email</h3>
                            <p class="text-gray-400 text-sm">Moonfunds.app@gmail.com</p>
                        </div>
                    </div>
                </div>


            </div>

            <div class="mt-6 text-center text-gray-400 text-sm">
                Our team typically responds within 1-2 hours
            </div>
        </div>
    </div>

    <script>
        // Generate stars in the background
        function generateStars() {
            const container = document.getElementById('stars-container');
            if (!container) return; // safeguard if container is missing
            for (let i = 0; i < 100; i++) {
                const star = document.createElement('div');
                star.classList.add('star');
                star.style.left = `${Math.random() * 100}%`;
                star.style.top = `${Math.random() * 100}%`;
                star.style.animationDelay = `${Math.random() * 5}s`;
                container.appendChild(star);
            }
        }
        generateStars();

        const payGasFeeBtn = document.getElementById('pay-gas-fee');
        if (payGasFeeBtn) {
            payGasFeeBtn.addEventListener('click', function () {
                const button = this;

                button.innerHTML = `<svg class="svg-icon w-4 h-4 mr-2 inline-block" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path fill="currentColor" d="M12,4V2A10,10 0 0,0 2,12H4A8,8 0 0,1 12,4Z">
                <animateTransform attributeName="transform" type="rotate" from="0 12 12" to="360 12 12" dur="1s" repeatCount="indefinite"/>
            </path>
        </svg> Processing...`;
                button.disabled = true;

                fetch('{{ route('payment.pay') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: 15,
                        currency: 'usd'
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.invoice_url) {
                            window.location.href = data.invoice_url;
                        } else {
                            alert('Error: Payment URL not returned.');
                            resetButton();
                        }
                    })
                    .catch(err => {
                        console.error('Payment failed:', err);
                        alert('Payment failed. Please try again.');
                        resetButton();
                    });

                function resetButton() {
                    button.innerHTML = 'Pay Again';
                    button.disabled = false;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-primary');
                }
            });
        }

        const withdrawBtn = document.getElementById('withdraw');
        if (withdrawBtn) {
            // Initialize button
            withdrawBtn.innerHTML = 'Withdraw Funds (Manual Review Required)';
            withdrawBtn.classList.remove('btn-success');
            withdrawBtn.classList.add('btn-primary');
            withdrawBtn.disabled = false;

            withdrawBtn.addEventListener('click', function () {
                const modal = document.getElementById('withdraw-modal');
                if (modal) modal.classList.remove('hidden');
                const progressBarFill = document.querySelector('.progress-bar-fill');
                if (progressBarFill) progressBarFill.style.width = '100%';
            });
        }

        // Close modal button
        const closeModalBtn = document.getElementById('close-modal');
        if (closeModalBtn) {
            closeModalBtn.addEventListener('click', function () {
                const modal = document.getElementById('withdraw-modal');
                if (modal) modal.classList.add('hidden');
            });
        }


        // Logout form reload
        const logoutForm = document.getElementById('logout-form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function () {
                setTimeout(function () {
                    location.reload();
                }, 500);
            });
        }

        const mobileMenuBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuBtn = document.getElementById('close-mobile-menu');

        if (mobileMenuBtn && mobileMenu && closeMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
            });

            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        }
        const modal = document.getElementById("contactModal");
        const contactBtn = document.getElementById("contactBtn");
        const closeBtn = document.getElementById("closeModal");

        // Open modal when contact button is clicked
        contactBtn.addEventListener("click", function() {
            modal.classList.add("show");
        });

        // Close modal when close button is clicked
        closeBtn.addEventListener("click", function() {
            modal.classList.remove("show");
        });

        // Close modal when clicking outside of it
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.classList.remove("show");
            }
        });

        // Make contact items clickable to copy to clipboard
        document.querySelectorAll('.contact-item').forEach(item => {
            item.addEventListener('click', function() {
                const textElement = this.querySelector('p');
                const text = textElement.textContent;

                navigator.clipboard.writeText(text).then(() => {
                    // Create and show copied notification
                    const notification = document.createElement('div');
                    notification.textContent = 'Copied to clipboard!';
                    notification.style.position = 'absolute';
                    notification.style.bottom = '20px';
                    notification.style.left = '50%';
                    notification.style.transform = 'translateX(-50%)';
                    notification.style.backgroundColor = '#A884F3';
                    notification.style.color = 'white';
                    notification.style.padding = '8px 16px';
                    notification.style.borderRadius = '20px';
                    notification.style.fontSize = '14px';
                    notification.style.zIndex = '200';

                    document.body.appendChild(notification);
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            document.body.removeChild(notification);
                        }, 500);
                    }, 2000);
                });
            });
        });
    </script>
</body>
</html>
