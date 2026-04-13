<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'address', 'city', 'phone', 'email', 'is_active', 'logo', 'cover_image', 'latitude', 'longitude'
    ];

    public function terrains()
    {
        return $this->hasMany(Terrain::class);
    }

    public function owner()
    {
        return $this->hasOne(User::class)->where('role', 'owner');
    }

    public static function existsWithNameAndCity($name, $city)
    {
        return self::where('name', $name)->where('city', $city)->exists();
    }
}