<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Traits\Activable;
use App\Models\Traits\HasProfilePhoto;
use App\Models\Traits\Sortable;
use App\QueryBuilders\UserQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, Searchable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Activable;
    use HasProfilePhoto;
    use Sortable;

    protected $appends = ['profile_photo_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'name',
        'email',
        'password',
        'avatar',
        'is_admin',
        'phone_number',
        'address',
        'matricule',
        'direction',
        'active',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'new_password_token',
        'remember_token',
        'pin_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_date' => 'datetime',
        'password' => 'hashed',
        'password_updated_at' => 'date',
        'new_password_token_expiration_date' => 'datetime',
        'is_admin' => 'boolean',
    ];

    protected $sortable = [
        'name',
        'firstname',
        'lastname',
        'matricule',
        'address',
        'phone_number',
        'roles.name',
        'active',
    ];

    public const CONFIGURED_PERMISSIONS = [
        ['name' => 'list_user', 'description' => 'Lister des comptes utilisateurs'],
        ['name' => 'create_user', 'description' => 'Créer un compte utilisateur'],
        ['name' => 'show_user', 'description' => 'Voir un compte utilisateur'],
        ['name' => 'edit_user', 'description' => 'Modifier un compte utilisateur'],
        ['name' => 'delete_user', 'description' => 'Supprimer un compte utilisateur'],
        ['name' => 'restore_user', 'description' => 'Restaurer un compte utilisateur'],
        ['name' => 'forceDelete_user', 'description' => 'Supprimer définitivement un compte utilisateur'],
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function hasNewPasswordTokenValid(string $token)
    {
        return $this->active &&
            $this->new_password_token === $token &&
            $this->new_password_token_expiration_date > now();
    }

    public function getNewPasswordUrl(): string
    {
        return route('new-password.edit', [
            'id' => $this->getKey(),
            'token' => $this->new_password_token,
        ]);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(Role::SUPER_ADMIN);
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->name,
            route('dashboard.clients.show', $this->id)
        );
    }

    public static function fieldToEagerLoad(): array
    {
        return [];
    }

    public function newEloquentBuilder($query)
    {
        return new UserQueryBuilder($query);
    }
}
