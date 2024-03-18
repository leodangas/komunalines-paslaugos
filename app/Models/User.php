<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];


    public function setPasswordAttribute($password) {
        $this->attributes['password'] = bcrypt($password);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function house() {
        return $this->belongsTo(House::class);
    }

    public function community() {
        return $this->belongsTo(Community::class, 'house_id', 'id');
    }
    public static function getValidName($name) {
        $i = 0;
        $defaultName = $name;
        do {
            if ($i !== 0) {
                $name = $defaultName . $i;
            }
            $i+=1;
        }
        while(User::where('login', $name)->exists());

        return $name;
    }

    public static function isAdmin() {
        return auth()->user()->role_id === Role::ADMIN_ID;
    }

    public static function isManager() {
        return auth()->user()->role_id === Role::MANAGER_ID;
    }
}
