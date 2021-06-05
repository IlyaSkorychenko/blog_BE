<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'avatar',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
        'avatar_url'
    ];

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get full URL for avatar.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? Storage::disk('public')->url($this->avatar) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function storeAvatarFile($file)
    {
        return Storage::disk('public')->putFile('avatars', $file);
    }

    public function deleteAvatarFile()
    {
        if ($this->avatar) {
            return Storage::disk('public')->delete($this->avatar);
        }
        return false;
    }
}
