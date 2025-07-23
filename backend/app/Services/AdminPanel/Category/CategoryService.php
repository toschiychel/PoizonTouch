<?php

namespace App\Services\AdminPanel\Category;

use App\DTO\Category\CategoryFullInfoDTO;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\Category\CategoryFullInfoResource;
use App\Models\Category;
use App\Models\CategoryBigPreviewImage;
use App\Models\CategorySmallPreviewImage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryService
{
    public function getPaginatedCategories(int $perPage)
    {
        return Category::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $categoriesHeader['count'] = Category::all()->count();
        $totalCategories = Category::count();

        $activeCategories = Category::has('products')->count();

        $categoriesHeader['activeCategories'] = $totalCategories > 0
            ? round(($activeCategories / $totalCategories) * 100, 2)
            : 0;

        return $categoriesHeader;
    }

    public function getCategoryFullInfo(Category $category)
    {
        $categoryDTO = new CategoryFullInfoDTO(
            id: $category->id,
            title: $category->title,
            bigPreviewImageUrl: $category->bigImageUrl,
            smallPreviewImageUrl: $category->imageUrl,
            created_at: $category->created_at->translatedFormat('j F Yг.'),
            updated_at: $category->updated_at->translatedFormat('j F Yг.'),
            deleted_at: $category->deleted_at ? $category->deleted_at->translatedFormat('j F Yг.') : 'Не удален',
        );

        return $categoryDTO;
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();

            $smallPreviewImage = $this->storeImage($data['preview_small_image'], 'small');
            $bigPreviewImage = $this->storeImage($data['preview_big_image'], 'big');

            $data = $this->prepareCategoryData($data, $smallPreviewImage, $bigPreviewImage);
            $category = Category::firstOrCreate($data);

            DB::commit();

            return $category;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function update($data, $category)
    {
        try {
            DB::beginTransaction();

            $smallPreviewImage = $category->preview_small_image;
            $bigPreviewImage = $category->preview_big_image;

            if (isset($data['preview_small_image'])) {
                $smallPreviewImage = $this->updateImage($data, $category, 'small');
            }

            if (isset($data['preview_big_image'])) {
                $bigPreviewImage = $this->updateImage($data, $category, 'big');
            }

            $data = $this->prepareCategoryData($data, $smallPreviewImage, $bigPreviewImage);

            $category->update($data);
            DB::commit();

            return $category;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    private function prepareCategoryData($data, $smallPreviewImage, $bigPreviewImage)
    {
        if (isset($data['preview_small_image'])) {
            unset($data['preview_small_image']);
            $data['small_preview_image_id'] = $smallPreviewImage->id;
        }
        if (isset($data['preview_big_image'])) {
            unset($data['preview_big_image']);
            $data['big_preview_image_id'] = $bigPreviewImage->id;
        }

        return $data;
    }

    private function storeImage($image, string $type)
    {
        $modelClass = $type === 'small' ? CategorySmallPreviewImage::class : CategoryBigPreviewImage::class;

        $name = $type . '_preview_' . md5(Carbon::now() . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('/categories/images', $image, $name);

        return $image = $modelClass::create(['file_path' => $path]);
    }

    private function updateImage($data, $category, $type)
    {
        $inputKey = "preview_{$type}_image";
        $relationName = "{$type}_preview_image";
        $fieldName = "{$type}_preview_image_id";

        $image = $this->storeImage($data[$inputKey], $type);
        $data[$fieldName] = $image->id;

        $oldImagePath = $category->{$relationName}->file_path;
        Storage::disk('public')->delete($oldImagePath);

        return $image;
    }
}
