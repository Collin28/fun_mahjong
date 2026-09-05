<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fun Mahjong - Edit User</title>
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
            <div class="max-w-3xl mx-auto space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-serif-title text-3xl font-bold text-gray-900">Edit User</h2>
                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm font-semibold text-[#C8521A] hover:underline">← Batal</a>
                </div>

                @if ($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-amber-900/10 rounded-2xl p-6 shadow-sm">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C8521A] text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Username</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C8521A] text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C8521A] text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Tanggal
                                Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}"
                                required
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C8521A] text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Password Baru <span
                                    class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password"
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-[#C8521A] text-sm"
                                placeholder="••••••••">
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-3 bg-[#C8521A] hover:bg-[#b04513] text-white font-semibold text-sm rounded-xl transition shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

</body>

</html>