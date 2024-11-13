<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'status' => UserStatus::class,
        ];
    }

    public function block(): bool
    {
        return $this->update(['status' => UserStatus::BLOCKED]);
    }

    /**
     * @throws Exception
     */
    public function unblock(): bool
    {
        if ($this->status == UserStatus::DEACTIVATED) {
            throw new Exception('User can not be unblocked');
        }

        return $this->update(['status' => UserStatus::ACTIVE]);
    }

    public function deactivate(): bool
    {
        return $this->update(['status' => UserStatus::DEACTIVATED]);
    }
}
