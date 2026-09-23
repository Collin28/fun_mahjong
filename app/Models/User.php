<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Total kemenangan dihitung dari poin Hu + Zi Mo.
     */
    protected function totalWins(): Attribute
    {
        return Attribute::get(fn () => ($this->hu_points ?? 0) + ($this->zi_mo_points ?? 0));
    }

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'birth_date',
        'profile_picture',
        'role',
        'total_wins',
        'weekly_wins',
        'hu_points',
        'zi_mo_points',
        'daily_played',
        'weekly_played',
        'total_played',
        'last_daily_reset',
        'last_weekly_reset',
    ];

    public function getProfileAnimalLabelAttribute(): string
    {
        return match ($this->profile_picture) {
            'panda' => 'Panda',
            'tiger' => 'Harimau',
            'fox' => 'Rubah',
            'cat' => 'Kucing',
            'rabbit' => 'Kelinci',
            'bear' => 'Beruang',
            'koala' => 'Koala',
            'penguin' => 'Penguin',
            default => 'Pemain',
        };
    }

    public function getProfileAnimalEmojiAttribute(): string
    {
        return match ($this->profile_picture) {
            'panda' => '🐼',
            'tiger' => '🐯',
            'fox' => '🦊',
            'cat' => '🐱',
            'rabbit' => '🐰',
            'bear' => '🐻',
            'koala' => '🐨',
            'penguin' => '🐧',
            default => mb_strtoupper(mb_substr($this->name ?? $this->username, 0, 2)),
        };
    }
}
