<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Mahjong - Manage Users</title>
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

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-orange-100/60 p-6 flex flex-col justify-between shrink-0">
        <div>
            <div class="text-center mb-10">
                <h1 class="font-serif-title text-2xl font-bold tracking-wider text-[#C8521A]">FUN MAHJONG</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Control Panel</p>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Daftar Users
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-semibold bg-[#FFF3EC] text-[#C8521A] transition">
                    Manage Users
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Leaderboard
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition">
                    Pengaturan System
                </a>
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

    <!-- Main Content Area -->
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
            <div class="max-w-6xl mx-auto space-y-6">

                <div class="flex items-center justify-between">
                    <h2 class="font-serif-title text-3xl font-bold text-gray-900">Manage Users</h2>
                </div>

                @if(session('success'))
                    <div
                        class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-700 text-sm font-medium flex justify-between items-center">
                        <span>{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif

                <div class="bg-white border border-amber-900/10 rounded-2xl shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                        <span class="text-sm font-semibold text-gray-500">Daftar Pengguna Terdaftar</span>
                        <span
                            class="text-xs font-bold bg-amber-100 text-amber-800 px-3 py-1 rounded-full">{{ $users->count() }}
                            Users</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-[#FAF8F5] border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="py-4 px-6">User</th>
                                    <th class="py-4 px-6">Email</th>
                                    <th class="py-4 px-6">Tanggal Lahir</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($users as $user)
                                    <tr class="hover:bg-amber-50/30 transition">
                                        <td class="py-4 px-6 font-medium text-gray-900">
                                            <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-400">@<span>{{ $user->username }}</span></div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">{{ $user->email }}</td>
                                        <td class="py-4 px-6 text-gray-600">
                                            {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="px-3 py-1.5 bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white rounded-lg text-xs font-semibold transition">Detail</a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-600 hover:text-white rounded-lg text-xs font-semibold transition">Edit</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg text-xs font-semibold transition">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-400">Belum ada data user.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>

</html>