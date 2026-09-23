@php
    $users = $users ?? collect();
    $metricLabel = $metricLabel ?? 'Match';
    $metricKey = $metricKey ?? 'total_played';
    $metricSuffix = $metricSuffix ?? 'Match';
    $totalLabel = $totalLabel ?? 'Total';
    $totalKey = $totalKey ?? 'total_played';
    $totalSuffix = $totalSuffix ?? '';
    $loyalty = $loyalty ?? false;
    $showPoints = $showPoints ?? false;
    $caption = $caption ?? null;
    $colspan = $showPoints ? 6 : 4;
@endphp

<div class="leaderboard-table-wrapper">
    <table class="leaderboard-table">
        @if($caption)
            <caption class="visually-hidden">{{ $caption }}</caption>
        @endif
        <thead>
            <tr>
                <th scope="col" class="col-rank">Posisi</th>
                <th scope="col">Pemain</th>
                <th scope="col">{{ $metricLabel }}</th>
                @if($showPoints)
                    <th scope="col" class="col-center">Hu</th>
                    <th scope="col" class="col-center">Zi Mo</th>
                @endif
                <th scope="col" class="col-end">{{ $totalLabel }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                @php
                    $rank = $loop->iteration;
                    $rankClass = $rank <= 3 ? 'rank-' . $rank : 'rank-other';
                    $displayName = $user->name ?? $user->username;
                    $avatar = $user->profile_animal_emoji;
                    $total = $user->{$totalKey} ?? 0;
                    $tier = null;
                    $tierClass = null;

                    if ($loyalty) {
                        if ($total >= 100)      { $tier = 'VIP Diamond';   $tierClass = 'tier-diamond'; }
                        elseif ($total >= 50)   { $tier = 'Gold Member';   $tierClass = 'tier-gold'; }
                        elseif ($total >= 20)   { $tier = 'Silver Member'; $tierClass = 'tier-silver'; }
                        else                    { $tier = 'Member';        $tierClass = 'tier-member'; }
                    }
                @endphp
                <tr>
                    <td data-label="Posisi">
                        <span class="rank-badge {{ $rankClass }}">{{ $rank }}</span>
                    </td>
                    <td data-label="Pemain">
                        <div class="player-info">
                            <span class="player-avatar" aria-label="Profil {{ $user->profile_animal_label }}">{{ $avatar }}</span>
                            <span class="player-name">{{ $displayName }}</span>
                        </div>
                    </td>
                    <td data-label="{{ $metricLabel }}">{{ $user->{$metricKey} ?? 0 }}@if($metricSuffix) {{ $metricSuffix }}@endif</td>
                    @if($showPoints)
                        <td data-label="Hu" class="col-center">{{ $user->hu_points ?? 0 }}</td>
                        <td data-label="Zi Mo" class="col-center">{{ $user->zi_mo_points ?? 0 }}</td>
                    @endif
                    <td data-label="{{ $totalLabel }}" class="col-end col-total {{ $loyalty ? $tierClass : '' }}">
                        @if($loyalty)
                            {{ $tier }}
                        @else
                            {{ number_format($total) }}@if($totalSuffix) {{ $totalSuffix }}@endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $colspan }}" class="leaderboard-empty">
                        <span class="empty-title">Belum ada data pemain</span>
                        <span class="empty-hint">Peringkat akan muncul setelah sesi permainan pertama tercatat.</span>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
