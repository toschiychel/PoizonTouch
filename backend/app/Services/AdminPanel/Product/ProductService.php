<?php

namespace App\Services\AdminPanel\Product;

use App\DTO\Product\ProductFullInfoDTO;
use App\Models\Category;
use App\Models\Color;
use App\Models\OrderPosition;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getPaginatedProducts(int $perPage)
    {
        return Product::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $header = [];

        $total = Product::count();
        $published = Product::where('is_published', 1)->where('count', '>', 0)->count();

        $header['count'] = $total;
        $header['activeProductPercent'] = $total > 0 ? round(($published / $total) * 100, 2) : 0;

        $topProduct = OrderPosition::query()
            ->select('product_id')
            ->where('type', 'product')
            ->whereNotNull('product_id')
            ->groupBy('product_id')
            ->orderByRaw('COUNT(order_id) DESC')
            ->first();

        $header['topProduct'] = $topProduct
            ? $topProduct->product
            : null;

        return $header;
    }

    public function getProductRelations()
    {
        return $productRelations = [
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'colors' => Color::all()
        ];
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();

            $data['preview_image'] = $this->imageStore($data['preview_image'], '/products/preview_images', 'preview_');

            $product = Product::create(Arr::except($data, ['tags', 'colors', 'images']));

            $product->tags()->attach($data['tags']);
            $product->colors()->attach($data['colors']);
            $this->processProductImages($data['images'], $product);

            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Product creation failed: ' . $th->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ошибка создания продукта']);
        }
    }

    public function update($data, $product)
    {
        try {
            DB::beginTransaction();

            $data['preview_image'] = $this->findOrCreatePreviewImage($product, $data['preview_image'] ?? null);
            $this->syncProductImages($product, $data['images'] ?? null);

            $product->update(Arr::except($data, ['tags', 'colors', 'images']));

            $product->tags()->sync($data['tags']);
            $product->colors()->sync($data['colors']);

            DB::commit();

            return $product;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Product update failed: ' . $th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->withErrors(['error' => 'Ошибка обновления продукта']);
        }
    }

    public function destroy($product)
    {
        try {
            DB::beginTransaction();

            Storage::disk('public')->delete($product->preview_image);
            $product->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Product destroy failed: ' . $th->getMessage() . $th->getFile() . $th->getLine());
            return redirect()->back()->withErrors(['error' => 'Ошибка удаления продукта']);
        }
    }

    private function findOrCreatePreviewImage($product, $newPreviewImage = null)
    {
        if ($newPreviewImage != null) {
            $newPreviewImage = $this->syncProductPreviewImage($newPreviewImage);
        } else {
            $newPreviewImage = $product->preview_image;
        }

        return $newPreviewImage;
    }

    private function syncProductPreviewImage($newPreviewImage)
    {
        $newPreviewImage = $this->imageStore($newPreviewImage, '/products/preview_images', 'preview_');
        return $newPreviewImage;
    }

    private function syncProductImages($product, $dataImages = null)
    {
        if ($dataImages != null) {
            $productOldImages = $product->images()->get();
            foreach ($dataImages as $imageId => $uploadedFile) {
                if (isset($productOldImages[$imageId])) {
                    $image = $productOldImages[$imageId];
                    Storage::disk('public')->delete($image->file_path);
                    $image->delete();
                }

                $path = $this->imageStore($uploadedFile, '/products/images' . 'id-' . $product->id);
                ProductImage::create([
                    'file_path' => $path,
                    'product_id' => $product->id
                ]);
            }
        }
    }

    private function imageStore($imageFile, string $basePath, string $filenamePrefix = '')
    {
        $hash = md5(Carbon::now() . '_' . $imageFile->getClientOriginalName());
        $extension = $imageFile->getClientOriginalExtension();
        $filename = $filenamePrefix . $hash . '.' . $extension;

        return Storage::disk('public')->putFileAs(
            $basePath,
            $imageFile,
            $filename
        );
    }

    private function processProductImages($dataImages, $product)
    {
        foreach ($dataImages as $image) {
            $path = $this->imageStore($image, '/products/images' . 'id-' . $product->id);
            ProductImage::create([
                'file_path' => $path,
                'product_id' => $product->id
            ]);
        }
    }

    public function getProductFullInfo(Product $product)
    {
        $productDTO = new ProductFullInfoDTO(
            id: $product->id,
            title: $product->title,
            description: $product->description,
            content: $product->content,
            previewImage: $product->preview_image,
            images: $product->images,
            price: $product->price,
            weight: $product->weight,
            count: $product->count,
            publicationStatus: $product->publishedStatus->label(),
            tags: $product->tags,
            colors: $product->colors,
            category: $product->category,
            created_at: $product->created_at->translatedFormat('j F Yг.'),
            updated_at: $product->updated_at->translatedFormat('j F Yг.'),
            deleted_at: $product->deleted_at ? $product->deleted_at->translatedFormat('j F Yг.') : 'Не удален',
        );

        return $productDTO;
    }
}
