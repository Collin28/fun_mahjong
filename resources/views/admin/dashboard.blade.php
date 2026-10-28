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
            <strong>{{ $weekStart->format('d/m/Y') }}</strong> sampai <strong>{{$weekEnd->format('d/m/Y') }}</strong>.
            Peringkat diurutkan otomatis dari nilai tertinggi. Reset mingguan dijalankan manual lewat tombol di samping.
        </div>

        <form action="{{ route('admin.reset-leaderboard') }}" method="POST"
            onsubmit="return confirm('Yakin ingin me-reset leaderboard mingguan? Seluruh weekly_played dan weekly_wins akan kembali ke 0.');">
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
            <button type="button" class="nav-tab-item active" role="tab" id="tabbtn-daily" aria-controls="tab-daily"
                aria-selected="true" data-tab="daily">Daily</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-weekly" aria-controls="tab-weekly"
                aria-selected="false" tabindex="-1" data-tab="weekly">Weekly</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-top-player" aria-controls="tab-top-player"
                aria-selected="false" tabindex="-1" data-tab="top-player">Top Player (Total Menang)</button>
            <button type="button" class="nav-tab-item" role="tab" id="tabbtn-top-loyal" aria-controls="tab-top-loyal"
                aria-selected="false" tabindex="-1" data-tab="top-loyal">Top Loyal (Sering Main)</button>
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
            // ---- TABS NAVIGATION ----
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

            // ---- STEPPER & AJAX SYNC ----
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

            // Memperbarui elemen teks (span/strong) DAN elemen <input> di seluruh tab
            function syncUser(username, values) {
                if (!values || typeof values !== 'object') return;

                Object.keys(values).forEach(function (field) {
                    if (values[field] === undefined || values[field] === null) return;

                    var selector = '[data-username="' + CSS.escape(username) + '"] [data-field="' + field + '"]';
                    document.querySelectorAll(selector).forEach(function (cell) {
                        if (cell.tagName === 'INPUT') {
                            cell.value = values[field];
                            cell.dataset.oldVal = values[field]; // Update baseline untuk manual change
                        } else {
                            cell.textContent = values[field];
                        }
                        cell.classList.remove('is-updated');
                        void cell.offsetWidth;
                        cell.classList.add('is-updated');
                    });
                });
            }

            // Kirim AJAX ke server
            async function sendStatAdjust(username, group, delta, targetRow, targetInput, oldVal) {
                var rowButtons = targetRow ? targetRow.querySelectorAll('.step-btn') : [];
                var inputs = targetRow ? targetRow.querySelectorAll('.point-input') : [];
                var counters = targetRow ? targetRow.querySelectorAll('.step-counter') : [];

                rowButtons.forEach(function (b) { b.disabled = true; });
                inputs.forEach(function (i) { i.disabled = true; });
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
                        // Revert jika gagal
                        if (targetInput) {
                            targetInput.value = oldVal;
                            targetInput.dataset.oldVal = oldVal;
                        }
                        notify(data.error || 'Gagal mengubah data.', 'error');
                    }
                } catch (err) {
                    if (targetInput) {
                        targetInput.value = oldVal;
                        targetInput.dataset.oldVal = oldVal;
                    }
                    notify('Koneksi bermasalah. Coba lagi.', 'error');
                } finally {
                    rowButtons.forEach(function (b) { b.disabled = false; });
                    inputs.forEach(function (i) { i.disabled = false; });
                    counters.forEach(function (c) { c.classList.remove('is-busy'); });
                }
            }

            // Handle Tombol Stepper (+/-) DENGAN POPUP KONFIRMASI OVERLAY
            document.querySelectorAll('.step-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var username = btn.dataset.username;
                    var group = btn.dataset.group;
                    var delta = Number(btn.dataset.delta);
                    if (!username) return;

                    var aksiText = delta > 0 ? 'menambah' : 'mengurangi';
                    var groupLabel = group === 'hu' ? 'Hu' : (group === 'zi_mo' ? 'Zi Mo' : 'Match');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Konfirmasi Perubahan',
                            text: `Yakin ingin ${aksiText} 1 poin ${groupLabel} untuk user ${username}?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                processStep();
                            }
                        });
                    } else {
                        if (confirm(`Yakin ingin ${aksiText} 1 poin ${groupLabel} untuk user ${username}?`)) {
                            processStep();
                        }
                    }

                    function processStep() {
                        var container = btn.closest('.stepper');
                        var input = container ? container.querySelector('.point-input') : null;
                        var counter = container ? container.querySelector('.step-counter') : null;
                        var oldVal = 0;

                        if (input) {
                            oldVal = parseInt(input.value, 10) || 0;
                            var newVal = Math.max(0, oldVal + delta);
                            input.value = newVal;
                            input.dataset.oldVal = newVal;
                        } else if (counter) {
                            oldVal = parseInt(counter.textContent, 10) || 0;
                            var newVal = Math.max(0, oldVal + delta);
                            counter.textContent = newVal;
                        }

                        var row = btn.closest('[data-username]');
                        sendStatAdjust(username, group, delta, row, input, oldVal);
                    }
                });
            });

            // Handle Perubahan Manual pada <input type="number"> DENGAN POPUP OVERLAY
            document.querySelectorAll('.point-input').forEach(function (input) {
                input.dataset.oldVal = input.value;

                input.addEventListener('change', function () {
                    var username = input.dataset.username;
                    var group = input.dataset.group;
                    var oldVal = parseInt(input.dataset.oldVal, 10) || 0;
                    var newVal = parseInt(input.value, 10) || 0;
                    var delta = newVal - oldVal;

                    if (delta === 0 || !username) return;

                    var groupLabel = group === 'hu' ? 'Hu' : (group === 'zi_mo' ? 'Zi Mo' : 'Match');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Konfirmasi Perubahan Manual',
                            text: `Ubah nilai ${groupLabel} untuk ${username} dari ${oldVal} menjadi ${newVal}?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, Simpan',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                input.dataset.oldVal = newVal;
                                var row = input.closest('[data-username]');
                                sendStatAdjust(username, group, delta, row, input, oldVal);
                            } else {
                                // Jika dibatalkan, kembalikan nilai input ke angka semula
                                input.value = oldVal;
                            }
                        });
                    } else {
                        if (confirm(`Ubah nilai ${groupLabel} untuk ${username} dari ${oldVal} menjadi ${newVal}?`)) {
                            input.dataset.oldVal = newVal;
                            var row = input.closest('[data-username]');
                            sendStatAdjust(username, group, delta, row, input, oldVal);
                        } else {
                            input.value = oldVal;
                        }
                    }
                });
            });
        })();
    </script>
@endsection