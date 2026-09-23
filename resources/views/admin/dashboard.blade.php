@extends('layouts.admin')

@section('title', 'Dashboard Admin - Fun Mahjong')
@section('topbar-title', 'Dashboard Admin')

@section('content')
    <h1 class="page-title">Teknikal Leaderboard</h1>

    @if(session('success'))
        <div class="alert-success" role="status">
            <span aria-hidden="true">&#x2705;</span> {{ session('success') }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert-error" role="alert">
            <span aria-hidden="true">&#x26A0;&#xFE0F;</span> {{ $errors->first() }}
        </div>
    @endif

    <!-- PERIODE MINGGUAN BERJALAN + RESET MANUAL -->
    <div class="reset-bar">
        <div class="info-box">
            <strong>Periode mingguan berjalan:</strong>
            <strong>{{ $weekStart->format('d/m/Y') }}</strong> sampai <strong>{{ $weekEnd->format('d/m/Y') }}</strong>.
            Peringkat diurutkan otomatis dari nilai tertinggi. Reset mingguan dijalankan manual lewat tombol di samping.
        </div>

        <form action="{{ route('admin.reset-leaderboard') }}" method="POST" onsubmit="return confirm('Yakin ingin me-reset leaderboard mingguan? Seluruh weekly_played dan weekly_wins akan kembali ke 0.');">
            @csrf
            <button type="submit" class="btn-submit btn-submit-danger btn-reset">
                <span aria-hidden="true">&#x21BB;</span> Reset Leaderboard
            </button>
        </form>
    </div>

    <!-- DATA LEADERBOARD & USER -->
    <h2 class="page-title">Data Leaderboard &amp; User</h2>

    <div class="card-box">
        <!-- TABULASI PERINGKAT -->
        <div class="nav-tabs" role="tablist" aria-label="Kategori leaderboard">
            <button type="button" class="nav-tab-item active" role="tab" id="tabbtn-daily" aria-controls="tab-daily" aria-selected="true" data-tab="daily">Daily</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-weekly" aria-controls="tab-weekly" aria-selected="false" tabindex="-1" data-tab="weekly">Weekly</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-top-player" aria-controls="tab-top-player" aria-selected="false" tabindex="-1" data-tab="top-player">Top Player (Total Menang)</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-top-loyal" aria-controls="tab-top-loyal" aria-selected="false" tabindex="-1" data-tab="top-loyal">Top Loyal (Sering Main)</button>
        </div>

        <!-- PANEL TABEL: DAILY -->
        <div class="tab-panel active" id="tab-daily" role="tabpanel" aria-labelledby="tabbtn-daily" tabindex="0">
            @include('admin.partials.leaderboard-table', ['users' => $dailyUsers, 'metricLabel' => 'Main Hari Ini', 'metricKey' => 'daily_played', 'suffix' => 'Main', 'caption' => 'Peringkat harian berdasarkan jumlah match hari ini'])
        </div>

        <!-- PANEL TABEL: WEEKLY -->
        <div class="tab-panel" id="tab-weekly" role="tabpanel" aria-labelledby="tabbtn-weekly" tabindex="0" hidden>
            @include('admin.partials.leaderboard-table', ['users' => $weeklyUsers, 'metricLabel' => 'Main Minggu Ini', 'metricKey' => 'weekly_played', 'suffix' => 'Main', 'caption' => 'Peringkat mingguan berdasarkan jumlah match minggu ini'])
        </div>

        <!-- PANEL TABEL: TOP PLAYER (KEMENANGAN) -->
        <div class="tab-panel" id="tab-top-player" role="tabpanel" aria-labelledby="tabbtn-top-player" tabindex="0" hidden>
            @include('admin.partials.leaderboard-table', ['users' => $topPlayers, 'metricLabel' => 'Total Kemenangan', 'metricKey' => 'total_wins', 'suffix' => 'Menang', 'hideMetric' => true, 'caption' => 'Peringkat berdasarkan total poin kemenangan'])
        </div>

        <!-- PANEL TABEL: TOP LOYAL (SERING MAIN) -->
        <div class="tab-panel" id="tab-top-loyal" role="tabpanel" aria-labelledby="tabbtn-top-loyal" tabindex="0" hidden>
            @include('admin.partials.leaderboard-table', ['users' => $topLoyal, 'metricLabel' => 'Total Permainan', 'metricKey' => 'total_played', 'suffix' => 'Main', 'caption' => 'Peringkat berdasarkan total sesi bermain'])
        </div>
    </div>

    <!-- Feedback untuk aksi stepper (+/-) -->
    <div class="stat-feedback" id="stat-feedback" role="status" aria-live="polite" hidden></div>
@endsection

@section('scripts')
    <script>
        (function () {
            // ---- TABS ----
            var tabs = Array.prototype.slice.call(document.querySelectorAll('.nav-tab-item[role="tab"]'));

            function activateTab(name, setFocus) {
                tabs.forEach(function (t) {
                    var selected = t.dataset.tab === name;
                    var panel = document.getElementById(t.getAttribute('aria-controls'));

                    t.classList.toggle('active', selected);
                    t.setAttribute('aria-selected', selected ? 'true' : 'false');
                    t.setAttribute('tabindex', selected ? '0' : '-1');

                    if (panel) {
                        panel.classList.toggle('active', selected);
                        panel.hidden = !selected;
                    }

                    if (selected && setFocus) t.focus();
                });
            }

            var initial = window.location.hash.replace('#', '') || 'daily';
            if (document.getElementById('tab-' + initial)) {
                activateTab(initial, false);
            }

            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    history.replaceState(null, '', '#' + tab.dataset.tab);
                    activateTab(tab.dataset.tab, false);
                });
            });

            var tablist = document.querySelector('.nav-tabs[role="tablist"]');
            if (tablist) {
                tablist.addEventListener('keydown', function (e) {
                    var current = tabs.indexOf(document.activeElement);
                    if (current === -1) return;

                    var next;
                    if (e.key === 'ArrowRight') next = (current + 1) % tabs.length;
                    else if (e.key === 'ArrowLeft') next = (current - 1 + tabs.length) % tabs.length;
                    else if (e.key === 'Home') next = 0;
                    else if (e.key === 'End') next = tabs.length - 1;
                    else return;

                    e.preventDefault();
                    history.replaceState(null, '', '#' + tabs[next].dataset.tab);
                    activateTab(tabs[next].dataset.tab, true);
                });
            }

            // ---- STEPPER ----
            var csrfToken = document.querySelector('meta[name="csrf-token"]');
            var feedback = document.getElementById('stat-feedback');
            var feedbackTimer;

            function notify(message, kind) {
                if (!feedback) return;
                feedback.textContent = message;
                feedback.className = 'stat-feedback stat-feedback-' + kind;
                feedback.hidden = false;

                window.clearTimeout(feedbackTimer);
                feedbackTimer = window.setTimeout(function () {
                    feedback.hidden = true;
                }, 4000);
            }

            // The same user can appear in several tab panels, so update every
            // matching cell instead of reloading the whole page.
            function syncUser(username, values) {
                Object.keys(values).forEach(function (field) {
                    var selector = '[data-username="' + CSS.escape(username) + '"] [data-field="' + field + '"]';
                    document.querySelectorAll(selector).forEach(function (cell) {
                        cell.textContent = values[field];
                        cell.classList.remove('is-updated');
                        void cell.offsetWidth;
                        cell.classList.add('is-updated');
                    });
                });
            }

            document.querySelectorAll('.step-btn').forEach(function (btn) {
                btn.addEventListener('click', async function () {
                    var username = btn.dataset.username;
                    var group = btn.dataset.group;
                    var delta = Number(btn.dataset.delta);
                    if (!username) return;

                    var row = btn.closest('[data-username]');
                    var rowButtons = row ? row.querySelectorAll('.step-btn') : [btn];
                    var counters = row ? row.querySelectorAll('.step-counter') : [];

                    rowButtons.forEach(function (b) { b.disabled = true; });
                    counters.forEach(function (c) { c.classList.add('is-busy'); });

                    try {
                        var res = await fetch('{{ route('admin.adjust-stat') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken ? csrfToken.content : ''
                            },
                            body: JSON.stringify({ username: username, group: group, delta: delta })
                        });

                        var data = await res.json().catch(function () { return {}; });

                        if (res.ok) {
                            syncUser(username, data);
                            notify('Data ' + username + ' diperbarui.', 'success');
                        } else {
                            notify(data.error || 'Gagal mengubah data.', 'error');
                        }
                    } catch (err) {
                        notify('Koneksi bermasalah. Coba lagi.', 'error');
                    } finally {
                        rowButtons.forEach(function (b) { b.disabled = false; });
                        counters.forEach(function (c) { c.classList.remove('is-busy'); });
                    }
                });
            });
        })();
    </script>
@endsection
