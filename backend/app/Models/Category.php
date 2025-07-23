<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'categories';
    protected $guarded = false;

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function small_preview_image() {
        return $this->belongsTo(CategorySmallPreviewImage::class);
    }

    public function big_preview_image() {
        return $this->belongsTo(CategoryBigPreviewImage::class);
    }

    public function getImageUrlAttribute() {
        return url('storage/' . $this->small_preview_image->file_path);
    }

    public function getBigImageUrlAttribute() {
        return url('storage/' . $this->big_preview_image->file_path);
    }
}
