@php
    $users = $users ?? collect();
    $metricLabel = $metricLabel ?? 'Total';
    $metricKey = $metricKey ?? 'total_played';
    $suffix = $suffix ?? 'Main';
    $hideMetric = $hideMetric ?? false;
    $caption = $caption ?? null;
    $colspan = $hideMetric ? 9 : 10;
@endphp

<div class="table-responsive" tabindex="0" role="region" aria-label="{{ $caption ?? 'Tabel leaderboard' }}">
<table class="table-leaderboard">
    @if($caption)
        <caption class="visually-hidden">{{ $caption }}</caption>
    @endif
    <thead>
        <tr>
            <th scope="col">Rank</th>
            <th scope="col">User Profile</th>
            <th scope="col">Username</th>
            <th scope="col">TTL / Ultah</th>
            @unless($hideMetric)
                <th scope="col">{{ $metricLabel }}</th>
            @endunless
            <th scope="col">Hu</th>
            <th scope="col">Zi Mo</th>
            <th scope="col">Total Menang</th>
            <th scope="col">Match</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            @php
                $displayName = $user->name ?? $user->username;
            @endphp
            <tr data-username="{{ $user->username }}">
                <td><strong>#{{ $loop->iteration }}</strong></td>

                <td>
                    <div class="user-profile-cell">
                        <span class="avatar-img" aria-hidden="true">
                            {{ $user->profile_animal_emoji }}
                        </span>
                        @if($user->is_birthday)
                            <span class="badge-ultah"><span aria-hidden="true">🎂</span> Ultah</span>
                        @endif
                    </div>
                </td>

                <td>{{ $user->username }}</td>

                <td>
                    {{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d/m') : '-' }}
                </td>

                @unless($hideMetric)
                    <td>
                        {{-- Value sits in its own span so the AJAX update does not wipe the suffix. --}}
                        <strong><span data-field="{{ $metricKey }}">{{ $user->{$metricKey} ?? 0 }}</span> {{ $suffix }}</strong>
                    </td>
                @endunless

                <td>
                    <div class="stepper">
                        <button type="button" class="step-btn step-minus" data-username="{{ $user->username }}" data-group="hu" data-delta="-1" aria-label="Kurangi poin Hu untuk {{ $displayName }}">&minus;</button>
                        <span class="step-counter" data-field="hu_points">{{ $user->hu_points ?? 0 }}</span>
                        <button type="button" class="step-btn step-plus" data-username="{{ $user->username }}" data-group="hu" data-delta="1" aria-label="Tambah poin Hu untuk {{ $displayName }}">+</button>
                    </div>
                </td>

                <td>
                    <div class="stepper">
                        <button type="button" class="step-btn step-minus" data-username="{{ $user->username }}" data-group="zi_mo" data-delta="-1" aria-label="Kurangi poin Zi Mo untuk {{ $displayName }}">&minus;</button>
                        <span class="step-counter" data-field="zi_mo_points">{{ $user->zi_mo_points ?? 0 }}</span>
                        <button type="button" class="step-btn step-plus" data-username="{{ $user->username }}" data-group="zi_mo" data-delta="1" aria-label="Tambah poin Zi Mo untuk {{ $displayName }}">+</button>
                    </div>
                </td>

                <td>
                    <strong data-field="total_wins">{{ $user->total_wins ?? 0 }}</strong>
                </td>

                <td>
                    <div class="stepper">
                        <button type="button" class="step-btn step-minus" data-username="{{ $user->username }}" data-group="matches" data-delta="-1" aria-label="Kurangi jumlah match untuk {{ $displayName }}">&minus;</button>
                        <span class="step-counter" data-field="total_played">{{ $user->total_played ?? 0 }}</span>
                        <button type="button" class="step-btn step-plus" data-username="{{ $user->username }}" data-group="matches" data-delta="1" aria-label="Tambah jumlah match untuk {{ $displayName }}">+</button>
                    </div>
                </td>

                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-edit">
                        Edit<span class="visually-hidden"> {{ $displayName }}</span>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ $colspan }}" class="table-empty">
                    <span class="empty-title">Belum ada data user</span>
                    <span class="empty-hint">User yang mendaftar akan muncul di sini.</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
