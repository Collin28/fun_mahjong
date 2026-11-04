@extends('layouts.public')

@section('title', 'Scorer Meja - FUN MAHJONG')
@section('meta-description', 'Pencatat skor meja mahjong: Hu 1 poin, Zi Mo 2 poin. Sekali tap langsung update leaderboard.')

@section('head')
<style>
    .scorer-wrap { max-width: 960px; margin: 0 auto; padding: 28px 16px 48px; }
    .scorer-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 8px; }
    .scorer-head h1 { font-size: 1.6rem; margin: 0; }
    .scorer-info { opacity: .8; font-size: .9rem; margin: 0 0 20px; }
    .setup-grid, .players-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (max-width: 640px) { .setup-grid, .players-grid { grid-template-columns: 1fr; } }
    .setup-grid { margin-bottom: 20px; }
    .setup-grid label, .player-card { background: #fff; border: 1px solid #e5e0d8; border-radius: 14px; padding: 14px; }
    .setup-grid label { font-weight: 700; font-size: .85rem; display: flex; flex-direction: column; gap: 6px; }
    .setup-grid select { padding: 10px; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; width: 100%; min-height: 44px; }
    .player-card { text-align: center; }
    .player-emoji { font-size: 2rem; }
    .player-name { font-weight: 800; font-size: 1.1rem; margin: 4px 0; }
    .player-score { font-size: 2.2rem; font-weight: 900; margin: 6px 0 12px; }
    .player-btns { display: flex; gap: 8px; }
    .player-btns button { flex: 1; min-height: 52px; border: 0; border-radius: 10px; font-weight: 800; font-size: 1rem; cursor: pointer; }
    .btn-hu { background: #15382B; color: #fff; }
    .btn-zimo { background: #E85D04; color: #fff; }
    .player-btns button:disabled { opacity: .4; cursor: not-allowed; }
    .scorer-actions { display: flex; gap: 8px; flex-wrap: wrap; margin: 20px 0 12px; }
    .scorer-actions button { min-height: 48px; padding: 10px 18px; border-radius: 10px; border: 1px solid #15382B; background: #fff; font-weight: 700; cursor: pointer; }
    .scorer-actions .btn-danger { background: #D00000; border-color: #D00000; color: #fff; }
    .scorer-status { min-height: 24px; font-weight: 700; margin: 8px 0; }
    .history { background: #fff; border: 1px solid #e5e0d8; border-radius: 14px; padding: 14px; }
    .history h2 { font-size: 1rem; margin: 0 0 8px; }
    .history div { padding: 4px 0; border-bottom: 1px solid #f0eadf; font-size: .9rem; }
    .history div:last-child { border-bottom: 0; }
</style>
@endsection

@section('content')
<div class="scorer-wrap">
    <div class="scorer-head">
        <h1>🀄 Scorer Meja</h1>
        <strong>Tangan #<span id="hand-number">0</span></strong>
    </div>
    <p class="scorer-info">Hu = 1 poin &nbsp;•&nbsp; Zi Mo = 2 poin &nbsp;•&nbsp; Sekali tap langsung update leaderboard (menang + match 4 pemain).</p>

    <div class="setup-grid" id="setup-grid">
        @for($i = 0; $i < 4; $i++)
            <label>Pemain {{ $i + 1 }}
                <select class="slot-select" data-slot="{{ $i }}">
                    <option value="">— Pilih pemain —</option>
                    @foreach($users as $user)
                        <option value="{{ $user->username }}" data-emoji="{{ $user->profile_animal_emoji }}" data-name="{{ $user->name }}">{{ $user->profile_animal_emoji }} {{ $user->username }} — {{ $user->name }}</option>
                    @endforeach
                </select>
            </label>
        @endfor
    </div>

    <div class="players-grid" id="players-grid"></div>

    <div class="scorer-actions">
        <button type="button" id="btn-seri">🤝 Seri (tanpa pemenang)</button>
        <button type="button" id="btn-undo">↩️ Undo tangan terakhir</button>
        <button type="button" id="btn-reset" class="btn-danger">↺ Reset Meja</button>
    </div>

    <p class="scorer-status" id="status" role="status" aria-live="polite"></p>

    <div class="history">
        <h2>Riwayat tangan</h2>
        <div id="history-list">Belum ada tangan tercatat.</div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var KEY = 'fun_mahjong_scorer_v1';
    var state = { slots: ['', '', '', ''], scores: [0, 0, 0, 0], hand: 0, history: [] };

    try {
        var saved = JSON.parse(localStorage.getItem(KEY) || 'null');
        if (saved && Array.isArray(saved.slots) && saved.slots.length === 4) state = saved;
    } catch (e) {}

    var selects = Array.prototype.slice.call(document.querySelectorAll('.slot-select'));
    var grid = document.getElementById('players-grid');
    var statusEl = document.getElementById('status');
    var csrf = document.querySelector('meta[name="csrf-token"]');

    function save() { try { localStorage.setItem(KEY, JSON.stringify(state)); } catch (e) {} }
    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
    function say(msg) { statusEl.textContent = msg; }
    function userInfo(username) {
        if (!username) return { emoji: '👤', name: 'Belum dipilih' };
        var sel = selects[0];
        for (var i = 0; i < selects.length; i++) {
            var opt = selects[i].querySelector('option[value="' + CSS.escape(username) + '"]');
            if (opt) return { emoji: opt.dataset.emoji || '👤', name: username + ' — ' + (opt.dataset.name || '') };
        }
        return { emoji: '👤', name: username };
    }

    function postStat(username, group, delta) {
        if (!username || !delta) return Promise.resolve();
        return fetch('{{ route('admin.adjust-stat') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf ? csrf.content : '' },
            body: JSON.stringify({ username: username, group: group, delta: delta })
        }).then(function (r) { if (!r.ok) throw new Error('gagal'); }).catch(function () { say('⚠️ Skor meja tersimpan, tapi leaderboard gagal terupdate. Cek koneksi lalu coba lagi.'); });
    }

    function ready() { return state.slots.every(function (s) { return !!s; }); }

    function render() {
        document.getElementById('hand-number').textContent = state.hand;
        selects.forEach(function (sel, i) { sel.value = state.slots[i] || ''; });

        grid.innerHTML = state.slots.map(function (username, i) {
            var info = userInfo(username);
            var dis = username ? '' : 'disabled';
            return '<div class="player-card">' +
                '<div class="player-emoji">' + esc(info.emoji) + '</div>' +
                '<div class="player-name">' + esc(info.name) + '</div>' +
                '<div class="player-score">' + state.scores[i] + '</div>' +
                '<div class="player-btns">' +
                    '<button type="button" class="btn-hu" data-win="' + i + '" data-type="hu" ' + dis + '>Hu +1</button>' +
                    '<button type="button" class="btn-zimo" data-win="' + i + '" data-type="zi_mo" ' + dis + '>Zi Mo +2</button>' +
                '</div></div>';
        }).join('');

        var list = document.getElementById('history-list');
        list.innerHTML = state.history.length
            ? state.history.slice(-10).reverse().map(function (h) { return '<div>#' + h.hand + ' — ' + esc(h.text) + '</div>'; }).join('')
            : 'Belum ada tangan tercatat.';
    }

    function record(type, winnerIdx) {
        if (!ready()) { alert('Pilih 4 pemain dulu ya bro.'); return; }
        var points = type === 'hu' ? 1 : 2;
        var winner = type === 'seri' ? null : state.slots[winnerIdx];
        var usernames = state.slots.slice();
        state.hand += 1;
        if (winnerIdx !== null && winnerIdx !== undefined) state.scores[winnerIdx] += points;

        var text = type === 'seri' ? 'Seri — tanpa pemenang' : (userInfo(winner).name + ' ' + (type === 'hu' ? 'Hu' : 'Zi Mo') + ' +' + points + ' → ' + state.scores[winnerIdx]);
        state.history.push({ hand: state.hand, type: type, winner: winner, points: points, usernames: usernames, text: text });
        save(); render();
        say('✅ Tangan #' + state.hand + ' tercatat.');

        var jobs = [];
        if (type !== 'seri') jobs.push(postStat(winner, type, points));
        usernames.forEach(function (u) { jobs.push(postStat(u, 'matches', 1)); });
        Promise.all(jobs);
    }

    selects.forEach(function (sel, i) {
        sel.addEventListener('change', function () {
            var val = sel.value;
            selects.forEach(function (other, j) { if (j !== i && other.value === val && val) other.value = ''; });
            state.slots = selects.map(function (s) { return s.value; });
            save(); render();
        });
    });

    grid.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-win]');
        if (btn) record(btn.dataset.type, Number(btn.dataset.win));
    });

    document.getElementById('btn-seri').addEventListener('click', function () { record('seri', null); });

    document.getElementById('btn-undo').addEventListener('click', function () {
        var last = state.history.pop();
        if (!last) { say('Belum ada tangan untuk di-undo.'); return; }
        state.hand = Math.max(0, state.hand - 1);
        if (last.winner) {
            var idx = last.usernames.indexOf(last.winner);
            if (idx > -1) state.scores[idx] = Math.max(0, state.scores[idx] - last.points);
            postStat(last.winner, last.type, -last.points);
        }
        last.usernames.forEach(function (u) { postStat(u, 'matches', -1); });
        save(); render();
        say('↩️ Tangan #' + last.hand + ' dibatalkan.');
    });

    document.getElementById('btn-reset').addEventListener('click', function () {
        if (!confirm('Reset skor meja? Skor leaderboard TIDAK ikut reset.')) return;
        state.scores = [0, 0, 0, 0]; state.hand = 0; state.history = [];
        save(); render(); say('↺ Meja direset. Siap meja berikutnya.');
    });

    render();
})();
</script>
@endsection
