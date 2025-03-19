<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MedineTech\Backoffice\Companies\Infrastructure\Persistence\Eloquent\CompanyModel;
use MedineTech\Backoffice\CompanyUsers\Infrastructure\Persistence\Eloquent\CompanyUserModel;
use MedineTech\Backoffice\Users\Infrastructure\Persistence\Eloquent\UserFilters;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "default_company_id",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'id' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(
            CompanyModel::class,
            'user_companies',
            'user_id',
            'company_id'
        );
    }

    public function company_users(): HasMany
    {
        return $this->hasMany(CompanyUserModel::class, 'user_id');
    }

    public function scopeFromFilters(Builder $builder, array $filters): void
    {
        (new UserFilters())->apply($builder, $filters);
    }
}
