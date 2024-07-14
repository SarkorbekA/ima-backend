<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property string $title
 * @property boolean $is_active
 * @property string $side
 * @property integer $category_id
 * @property integer $parent_id
 */
class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

}

