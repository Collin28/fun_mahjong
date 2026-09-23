@php
    $dailyUsers  = $dailyUsers ?? collect();
    $weeklyUsers = $weeklyUsers ?? collect();
    $topPlayers  = $topPlayers ?? collect();
    $topLoyal    = $topLoyal ?? collect();

    $winRatePlayers = $topPlayers->map(function ($user) {
        $user->win_rate = $user->total_played > 0
            ? round(($user->total_wins / $user->total_played) * 100, 1) . '%'
            : '0%';
        return $user;
    });
@endphp

<section class="leaderboard-section" id="leaderboard">
    <div class="leaderboard-header">
        <div>
            <span class="sub-label">TOP PLAYERS & COMMUNITY</span>
            <div class="section-title">
                <h2>Papan Peringkat</h2>
            </div>
        </div>
        <p class="section-desc">Lihat siapa yang mendominasi meja permainan dan pemain terloyal di Fun Mahjong.</p>
    </div>

    <div class="leaderboard-tabs" role="tablist" aria-label="Kategori papan peringkat">
        <button type="button" class="tab-btn active" role="tab" id="tabbtn-daily" aria-controls="tab-daily" aria-selected="true">Daily Rank</button>
        <button type="button" class="tab-btn" role="tab" id="tabbtn-weekly" aria-controls="tab-weekly" aria-selected="false" tabindex="-1">Weekly Rank</button>
        <button type="button" class="tab-btn" role="tab" id="tabbtn-top-player" aria-controls="tab-top-player" aria-selected="false" tabindex="-1">Top Players</button>
        <button type="button" class="tab-btn" role="tab" id="tabbtn-top-loyal" aria-controls="tab-top-loyal" aria-selected="false" tabindex="-1">Top Loyal</button>
    </div>

    <div id="tab-daily" class="tab-content active" role="tabpanel" aria-labelledby="tabbtn-daily" tabindex="0">
        @include('partials.public-leaderboard-table', [
            'users' => $dailyUsers,
            'caption' => 'Peringkat harian berdasarkan jumlah match hari ini',
            'metricLabel' => 'Match Hari Ini',
            'metricKey' => 'daily_played',
            'metricSuffix' => 'Match',
            'totalLabel' => 'Total Win',
            'totalKey' => 'total_wins',
            'totalSuffix' => '',
            'showPoints' => true,
        ])
    </div>

    <div id="tab-weekly" class="tab-content" role="tabpanel" aria-labelledby="tabbtn-weekly" tabindex="0" hidden>
        @include('partials.public-leaderboard-table', [
            'users' => $weeklyUsers,
            'caption' => 'Peringkat mingguan berdasarkan jumlah match minggu ini',
            'metricLabel' => 'Match Minggu Ini',
            'metricKey' => 'weekly_played',
            'metricSuffix' => 'Match',
            'totalLabel' => 'Total Win',
            'totalKey' => 'total_wins',
            'totalSuffix' => '',
            'showPoints' => true,
        ])
    </div>

    <div id="tab-top-player" class="tab-content" role="tabpanel" aria-labelledby="tabbtn-top-player" tabindex="0" hidden>
        @include('partials.public-leaderboard-table', [
            'users' => $winRatePlayers,
            'caption' => 'Peringkat pemain terbaik berdasarkan total poin kemenangan',
            'metricLabel' => 'Win Rate',
            'metricKey' => 'win_rate',
            'metricSuffix' => '',
            'totalLabel' => 'Total Win (Hu + Zi Mo)',
            'totalKey' => 'total_wins',
            'totalSuffix' => '',
            'showPoints' => true,
        ])
    </div>

    <div id="tab-top-loyal" class="tab-content" role="tabpanel" aria-labelledby="tabbtn-top-loyal" tabindex="0" hidden>
        @include('partials.public-leaderboard-table', [
            'users' => $topLoyal,
            'caption' => 'Peringkat pemain terloyal berdasarkan total sesi bermain',
            'metricLabel' => 'Total Sesi',
            'metricKey' => 'total_played',
            'metricSuffix' => 'Sesi',
            'totalLabel' => 'Status Loyalty',
            'totalKey' => 'total_played',
            'totalSuffix' => '',
            'loyalty' => true,
        ])
    </div>
</section>

<script>
    (function () {
        var list = document.querySelector('.leaderboard-tabs[role="tablist"]');
        if (!list) return;

        var tabs = Array.prototype.slice.call(list.querySelectorAll('[role="tab"]'));

        function select(tab, setFocus) {
            tabs.forEach(function (t) {
                var selected = t === tab;
                var panel = document.getElementById(t.getAttribute('aria-controls'));

                t.classList.toggle('active', selected);
                t.setAttribute('aria-selected', selected ? 'true' : 'false');
                // Roving tabindex: only the active tab is a tab stop.
                t.setAttribute('tabindex', selected ? '0' : '-1');

                if (panel) {
                    panel.classList.toggle('active', selected);
                    panel.hidden = !selected;
                }
            });

            if (setFocus) tab.focus();
        }

        list.addEventListener('click', function (e) {
            var tab = e.target.closest('[role="tab"]');
            if (tab) select(tab, false);
        });

        list.addEventListener('keydown', function (e) {
            var current = tabs.indexOf(document.activeElement);
            if (current === -1) return;

            var next;
            if (e.key === 'ArrowRight') next = (current + 1) % tabs.length;
            else if (e.key === 'ArrowLeft') next = (current - 1 + tabs.length) % tabs.length;
            else if (e.key === 'Home') next = 0;
            else if (e.key === 'End') next = tabs.length - 1;
            else return;

            e.preventDefault();
            select(tabs[next], true);
        });
    })();
</script>