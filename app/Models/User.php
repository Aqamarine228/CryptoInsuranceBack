<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\Sanctum;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'float',
    ];

    public function createToken(
        string            $name,
        array             $abilities = ['*'],
        DateTimeInterface|null $expiresAt = null
    ): NewAccessToken {
        $plainTextToken = Str::random(40);
        $token = Sanctum::$personalAccessTokenModel::unguarded(
            function () use ($name, $plainTextToken, $abilities, $expiresAt) {
                return Sanctum::$personalAccessTokenModel::create([
                    'tokenable_type' => $this::class,
                    'tokenable_id' => $this->id,
                    'name' => $name,
                    'token' => hash('sha256', $plainTextToken),
                    'abilities' => $abilities,
                    'expires_at' => $expiresAt,
                ]);
            }
        );

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function getEmailAttribute($value)
    {
        return strtolower($value);
    }

    protected function newMorphMany(Builder $query, Model $parent, $type, $id, $localKey): MorphMany
    {
        return new MorphMany($query, $this->downcast(), $type, $id, $localKey);
    }

    public function downcast(): self
    {
        return Model::unguarded(fn () => (new User)->fill($this->toArray()));
    }
}
