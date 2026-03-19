<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Practical Test</title>
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
            <h1 class="text-2xl font-bold tracking-tight mb-2 uppercase tracking-widest">Forgot Password</h1>
            <p class="text-gray-400 text-sm italic">Recovery system initialization.</p>
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

        <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                    placeholder="name@example.com">
            </div>

            <button type="submit"
                class="w-full bg-white text-black font-bold py-3 text-sm hover:bg-gray-200 transition-colors uppercase tracking-widest">
                Send Reset Link
            </button>
        </form>

        <div class="mt-12 pt-8 border-t border-white/10 text-center text-xs text-gray-500">
            Back to 
            <a href="{{ route('login') }}" class="text-white hover:underline underline-offset-4">Sign in</a>
        </div>
    </div>
</body>
</html>
