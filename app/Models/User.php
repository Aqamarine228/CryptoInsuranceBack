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
    ];

    public function createToken(
        string            $name,
        array             $abilities = ['*'],
        DateTimeInterface $expiresAt = null
    ): NewAccessToken {
        $plainTextToken = Str::random(40);
        $token = Sanctum::$personalAccessTokenModel::unguarded(
            function () use ($name, $abilities, $expiresAt, $plainTextToken) {
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

    protected function newMorphMany(Builder $query, Model $parent, $type, $id, $localKey): MorphMany
    {
        return new MorphMany($query, $this->downcast(), $type, $id, $localKey);
    }

    public function downcast(): User
    {
        return Model::unguarded(fn () => (new User)->fill($this->toArray()));
    }
}
