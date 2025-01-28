<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Media\HasMedia;
use App\Media\Mediable;
use App\Modules\RolePermission\Traits\RolePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Mediable
{
    use HasApiTokens, HasFactory, HasMedia, Notifiable , RolePermission;

    protected $guarded = [];

    protected $appends = ['avatar'];

    protected $hidden = [
        'media',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => UserRole::class,
    ];

    public static $ROLE_SUPER_ADMIN = 1;

    public static $ROLE_ADMIN = 2;

    public static $ROLE_USER = 3;

    public static $ROLE_MERCHANT = 4;

    public static $roles = [
        1 => 'Super Admin',
        2 => 'Admin',
        3 => 'USER',
        4 => 'MERCHANT',
    ];

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeCustomer($query)
    {
        return $query->where('role', self::$ROLE_USER);
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstUrl('avatar');
    }

    public function setAvatarAttribute($file)
    {
        if ($file) {
            $existingMedia = $this->media()->where('collection_name', 'avatar')->first();
            if ($existingMedia) {
                $this->deleteMedia($existingMedia->id);
            }
            $this->addMedia($file, 'avatar', ['tags' => '']);
        }
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function hasPermission($permissionName)
    {
        $permissions = Cache::remember('user_permissions'.$this->id, now()->addMonths(5), function () {
            return $this->getAllPermissions()->pluck('name')->toArray();
        });

        return in_array($permissionName, $permissions);
    }
}
