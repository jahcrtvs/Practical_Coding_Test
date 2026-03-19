<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Practical Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #000; color: #fff; font-family: 'Inter', sans-serif; }
        .border-base { border-color: #222; }
        .bg-card { background-color: #000; }
        .hover-row:hover { background-color: #0a0a0a; }
    </style>
</head>
<body class="min-h-screen">
    <!-- Navbar -->
    <nav class="border-b border-base py-6 bg-black sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <span class="text-xl font-bold tracking-tighter uppercase">PRACTICAL PROG TEST</span>
            <div class="flex items-center space-x-8 text-[11px] uppercase tracking-widest font-bold">
                <span class="text-gray-500">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-400 transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-16">
        <div class="mb-16 flex justify-between items-baseline border-b border-base pb-8">
            <div>
                <h1 class="text-4xl font-bold tracking-tight mb-2">Dashboard</h1>
                @if(auth()->user()->isAdmin())
                    <span class="text-[9px] bg-white text-black px-2 py-0.5 font-bold uppercase tracking-widest inline-block border border-white/50">Admin Mode</span>
                @endif
                <p class="text-gray-500 text-sm">System records and management.</p>
            </div>
            <a href="{{ route('profiles.create') }}" 
                class="bg-white text-black text-[11px] px-6 py-3 font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors">
                + New Profile
            </a>
        </div>

        @if(session('success'))
            <div class="border border-white/20 text-white text-xs p-4 rounded mb-12">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-base">
                        <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold {{ auth()->user()->isAdmin() ? 'w-1/4' : 'w-1/3' }}">Identity</th>
                        @if(auth()->user()->isAdmin())
                            <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold w-1/4">Owner</th>
                        @endif
                        <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold w-1/4">Contact</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold w-1/4">Status</th>
                        <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($profiles as $profile)
                        <tr class="border-b border-base hover-row transition-colors group">
                            <td class="py-6">
                                <div class="font-bold text-white">{{ $profile->first_name }} {{ $profile->last_name }}</div>
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td class="py-6 text-gray-400">
                                    <div class="text-[10px] uppercase tracking-widest">{{ $profile->user->name }}</div>
                                    <div class="text-[9px] opacity-50">{{ $profile->user->email }}</div>
                                </td>
                            @endif
                            <td class="py-6 text-gray-400">
                                <div>{{ $profile->email }}</div>
                            </td>
                            <td class="py-6">
                                <span class="text-[10px] uppercase tracking-widest border border-gray-800 px-2 py-1 text-gray-400">Active</span>
                            </td>
                            <td class="py-6 text-right space-x-6">
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="text-gray-500 hover:text-white transition uppercase text-[10px] tracking-widest font-bold">Edit</a>
                                <button type="button" 
                                    onclick="openDeleteModal({{ $profile->id }}, '{{ $profile->first_name }} {{ $profile->last_name }}')"
                                    class="text-gray-500 hover:text-red-500 transition uppercase text-[10px] tracking-widest font-bold">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-24 text-center text-gray-600 border-b border-base">
                                <p class="text-xs uppercase tracking-widest">No records found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/95 backdrop-blur-md transition-all duration-300">
        <div class="w-full max-w-sm border border-white/10 bg-black p-8 shadow-2xl">
            <h2 class="text-2xl font-bold mb-4 tracking-tight uppercase tracking-widest">Confirm Deletion</h2>
            <p class="text-gray-500 text-xs mb-10 leading-relaxed uppercase tracking-wider">
                You are about to permanently remove <span id="modalProfileName" class="text-white font-bold"></span>. 
                Please enter your password to authorize this action.
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="mb-10 relative group/field">
                    <label for="delete_password" class="block text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-3">Master Password</label>
                    <input type="password" name="password" id="delete_password" required
                        class="w-full bg-[#0a0a0a] border border-[#222] text-white px-4 py-4 rounded-none outline-none focus:border-white transition-all text-sm font-mono pr-12"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('delete_password')" class="absolute right-0 bottom-0 top-7 px-4 flex items-center text-gray-500 hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M24 12s-4.873-9-12-9S0 12 0 12s4.873 9 12 9 12-9 12-9z"/></svg>
                    </button>
                    @if($errors->has('deletion_password'))
                        <p class="text-red-500 text-[10px] mt-3 uppercase tracking-widest font-bold">{{ $errors->first('deletion_password') }}</p>
                    @endif
                </div>

                <div class="flex flex-col space-y-4">
                    <button type="submit" class="bg-white text-black py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors">
                        Execute Deletion
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="text-gray-500 py-2 text-[10px] font-bold uppercase tracking-widest hover:text-white transition-colors">
                        Abort
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        function openDeleteModal(profileId, profileName) {
            document.getElementById('modalProfileName').innerText = profileName;
            document.getElementById('deleteForm').action = '/profiles/' + profileId;
            document.getElementById('deleteModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('delete_password').focus();
            }, 100);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('delete_password').value = '';
        }

        // Handle validation errors by keeping modal open
        @if(session('error_profile_id'))
            window.onload = function() {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteForm').action = '/profiles/{{ session('error_profile_id') }}';
                document.getElementById('modalProfileName').innerText = 'Selected Profile';
                document.getElementById('delete_password').focus();
            }
        @endif
    </script>
</body>
</html>
