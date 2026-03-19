<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Profile - Practical Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #000; color: #fff; font-family: 'Inter', sans-serif; }
        .input-field { background-color: #111; border: 1px solid #333; color: #fff; }
        .input-field:focus { border-color: #fff; }
    </style>
</head>
<body class="min-h-screen p-6 sm:p-12">
    <div class="max-w-2xl mx-auto">
        <div class="mb-16 pb-8 border-b border-white/10 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold tracking-tight mb-2">New Profile</h1>
                <p class="text-gray-500 text-sm italic">System record entry.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-[10px] uppercase tracking-widest text-gray-500 hover:text-white transition font-bold">Cancel</a>
        </div>

        @if($errors->any())
            <div class="border border-red-500/50 text-red-400 text-xs p-4 rounded mb-12">
                <ul class="list-none space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profiles.store') }}" method="POST" class="space-y-12">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-12">
                <div>
                    <label for="first_name" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required
                        class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                        placeholder="John">
                </div>
                <div>
                    <label for="last_name" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                        class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                        placeholder="Doe">
                </div>
            </div>

            <div>
                <label for="email" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                    placeholder="john.doe@example.com">
            </div>

            <div>
                <label for="phone" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Phone (Optional)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm"
                    placeholder="+0 000 000 000">
            </div>

            <div>
                <label for="bio" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Bio / Notes</label>
                <textarea id="bio" name="bio" rows="4" 
                    class="input-field w-full px-4 py-3 rounded-none outline-none transition-all text-sm resize-none"
                    placeholder="Technical overview or personal notes...">{{ old('bio') }}</textarea>
            </div>

            <div class="pt-8 border-t border-white/10 flex justify-end">
                <button type="submit" 
                    class="bg-white text-black text-[11px] px-12 py-4 font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors">
                    Save Record
                </button>
            </div>
        </form>
    </div>
</body>
</html>
