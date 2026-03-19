<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Practical Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #000; color: #fff; font-family: 'Inter', sans-serif; }
        .input-field { background-color: #111; border: 1px solid #333; color: #fff; }
        .input-field:focus { border-color: #fff; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-sm">
        <div class="mb-12">
            <h1 class="text-2xl font-bold tracking-tight mb-2">Sign in</h1>
            <p class="text-gray-400 text-sm">Welcome back to the dashboard.</p>
        </div>

        @if(session('success'))
            <div class="border border-white/20 text-white text-xs p-4 rounded mb-8">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="border border-red-500/50 text-red-400 text-xs p-4 rounded mb-8">
                <ul class="list-none space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                    placeholder="email@example.com">
            </div>

            <div class="relative group/field">
                <label for="password" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm pr-12"
                    placeholder="••••••••">
                <button type="button" onclick="togglePassword('password')" class="absolute right-0 bottom-0 top-6 px-4 flex items-center text-gray-500 hover:text-white transition-colors">
                    <svg id="password_eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M24 12s-4.873-9-12-9S0 12 0 12s4.873 9 12 9 12-9 12-9z"/></svg>
                </button>
            </div>

            <div class="flex items-center justify-between text-[11px] text-gray-500">
                <label class="flex items-center space-x-2 cursor-pointer hover:text-white transition">
                    <input type="checkbox" name="remember" class="w-3 h-3 border-gray-700 bg-black rounded-none">
                    <span>Remember</span>
                </label>
                <a href="{{ route('password.request') }}" class="hover:text-white transition">Forgot Password?</a>
            </div>

            <button type="submit"
                class="w-full bg-white text-black font-bold py-3 text-sm hover:bg-gray-200 transition-colors uppercase tracking-widest">
                Login
            </button>
        </form>

        <div class="mt-12 pt-8 border-t border-white/10 text-center text-xs text-gray-500">
            No account? 
            <a href="{{ route('register') }}" class="text-white hover:underline underline-offset-4">Register here</a>
        </div>
    </div>
    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
