<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $read_count_data)
 * @method static where(string $string, int $post_id)
 */
class PostCount extends Model
{
    use HasFactory;
    protected $guarded = [];
}
