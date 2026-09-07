<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Mahjong - Detail User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF8F5;
        }

        .font-serif-title {
            font-family: 'Playfair Display', serif;
        }
    </style>
</head>

<body class="flex min-h-screen text-gray-800">

    <aside class="w-64 bg-white border-r border-orange-100/60 p-6 flex flex-col justify-between shrink-0">
        <div>
            <div class="text-center mb-10">
                <h1 class="font-serif-title text-2xl font-bold tracking-wider text-[#C8521A]">FUN MAHJONG</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Control Panel</p>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">Daftar
                    Users</a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold bg-[#FFF3EC] text-[#C8521A] transition">Manage
                    Users</a>
                <a href="#"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">Leaderboard</a>
                <a href="#"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">Pengaturan
                    System</a>
            </nav>
        </div>
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 px-4 rounded-xl border border-rose-300 text-rose-600 hover:bg-rose-50 text-sm font-semibold transition flex items-center justify-center">
                    <i class="fa-solid fa-square-minus mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-white border-b border-orange-100/60 px-8 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-800">Dashboard Admin</h2>
            <div class="flex items-center space-x-3">
                <span
                    class="w-8 h-8 rounded-full bg-[#E58354]/20 text-[#C8521A] text-xs font-bold flex items-center justify-center border border-[#E58354]/40">Adm</span>
                <span class="text-sm font-semibold text-gray-700">Administrator</span>
            </div>
        </header>

        <div class="p-8 flex-1 overflow-y-auto">
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif-title text-3xl font-bold text-gray-900">Detail Users</h2>
                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm font-semibold text-[#C8521A] hover:underline">← Kembali ke List</a>
                </div>

                <div class="bg-white border border-amber-900/10 rounded-2xl p-6 shadow-sm space-y-6">
                    <div class="flex items-center space-x-4 border-b border-gray-100 pb-6">
                        <div
                            class="w-16 h-16 rounded-full bg-[#1E5235] text-amber-300 font-bold text-xl flex items-center justify-center shadow-sm">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-400">@<span>{{ $user->username }}</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 text-sm">
                        <div>
                            <label class="text-xs text-gray-400 uppercase font-semibold">Email</label>
                            <p class="font-semibold text-gray-800 mt-1">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase font-semibold">Tanggal Lahir</label>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase font-semibold">Total Kemenangan (Poin)</label>
                            <p class="font-semibold text-[#C8521A] mt-1">{{ $user->total_wins ?? 0 }} Win</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase font-semibold">Total Permainan (Match)</label>
                            <p class="font-semibold text-[#1E5235] mt-1">{{ $user->total_played ?? 0 }} Match</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>