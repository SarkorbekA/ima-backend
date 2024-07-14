<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int $id
 * @property string $title
 * @property boolean $is_active
 * @property string $side
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_active',
        'side'
    ];

    public function items(): HasMany
    {
        return $this->HasMany(Item::class);
    }

}




