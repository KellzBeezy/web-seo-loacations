<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($isAdmin) ? 'Admin' : 'Tenant' }} Login | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .login-content {
            z-index: 1;
            position: relative;
        }

        .bg-tenant {
            background: linear-gradient(to bottom right, #0a192f, #112240, #020c1b);
        }

        .bg-admin {
            background: linear-gradient(to bottom right, #2d0a0a, #4a0e0e, #1a0505);
        }

        /* Floating Animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float-card {
            animation: float 6s ease-in-out infinite;
        }

        /* Loading Spinner Animation */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        .loading .spinner {
            display: block;
        }

        .loading .btn-text {
            display: none;
        }
    </style>
</head>

<body
    class="min-h-screen flex items-center justify-center overflow-hidden {{ isset($isAdmin) ? 'bg-admin' : 'bg-tenant' }}">

    <div id="particles-js"></div>

    <div class="w-full max-w-md px-6 login-content">
        <div
            class="float-card bg-white/10 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/20">

            <div class="flex justify-center mb-6">
                <div
                    class="p-4 rounded-2xl {{ isset($isAdmin) ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400' }}">
                    @if(isset($isAdmin))
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    @else
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    @endif
                </div>
            </div>

            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white tracking-tight">
                    {{ isset($isAdmin) ? 'Admin Login' : 'Tenant Login' }}
                </h2>
                <p class="text-white/60 mt-2 text-sm">Secure Portal Access</p>
            </div>

            @if(session('error') || $errors->any())
                <div
                    class="bg-red-500/20 border border-red-500/50 text-red-100 p-4 mb-6 text-sm rounded-2xl backdrop-blur-sm">
                    @if(session('error'))
                        <p>{{ session('error') }}</p>
                    @endif
                    @if($errors->any())
                        <ul class="list-disc list-inside text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ url()->current() }}" class="space-y-5" id="loginForm">
                @csrf
                <div>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-white/30 focus:ring-2 {{ isset($isAdmin) ? 'focus:ring-red-500' : 'focus:ring-blue-500' }} focus:outline-none transition-all"
                        placeholder="Email Address" required>
                </div>

                <div>
                    <input type="password" name="password"
                        class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-white placeholder-white/30 focus:ring-2 {{ isset($isAdmin) ? 'focus:ring-red-500' : 'focus:ring-blue-500' }} focus:outline-none transition-all"
                        placeholder="Password" required>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full h-[60px] flex items-center justify-center rounded-2xl font-bold text-white shadow-lg transform transition duration-200 hover:scale-[1.02] active:scale-[0.98] {{ isset($isAdmin) ? 'bg-gradient-to-r from-red-600 to-red-700 shadow-red-900/20' : 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-blue-900/20' }}">
                    <span class="btn-text">Enter Dashboard</span>
                    <div class="spinner"></div>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <a href="{{ isset($isAdmin) ? route('login') : route('admin.login') }}"
                    class="text-xs font-medium text-white/40 hover:text-white transition uppercase tracking-widest">
                    {{ isset($isAdmin) ? 'Switch to Tenant Portal' : 'Switch to Admin Portal' }}
                </a>
            </div>
        </div>

        <p class="mt-10 text-center text-white/20 text-xs tracking-widest uppercase">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        // Initialize Background
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 120, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#ffffff" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.5, "random": true, "anim": { "enable": true, "speed": 1, "opacity_min": 0.1, "sync": false } },
                "size": { "value": 3, "random": true },
                "line_linked": { "enable": false },
                "move": { "enable": true, "speed": 0.8, "direction": "none", "random": true, "straight": false, "out_mode": "out", "bounce": false }
            },
            "retina_detect": true
        });

        // Handle Spinner on Submit
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');

        loginForm.addEventListener('submit', function () {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true; // Prevent double submission
        });
    </script>
</body>

</html>