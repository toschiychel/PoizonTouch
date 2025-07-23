<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBigPreviewImage extends Model
{
    protected $table = 'category_big_preview_images';
    protected $guarded = false;

    public $timestamps = false;

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
