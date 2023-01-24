<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(\any[] $category_data)
 * @method static orderBy(string $string)
 * @method static where(string $string, int $int)
 * @method static pluck(string $string, string $string1)
 */
class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
