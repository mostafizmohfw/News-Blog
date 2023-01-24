<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $profile_data)
 * @method static where(string $string, int|string|null $id)
 */
class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];
}
