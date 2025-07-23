<?php

namespace App\Services\AdminPanel\Color;

use App\DTO\Color\ColorFullInfoDTO;
use App\Models\Color;

class ColorService
{
    public function getPaginatedColors(int $perPage)
    {
        return Color::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $header = [];

        $totalColors = Color::count();
        $activeColors = Color::has('products')->count();

        $header['count'] = $totalColors;

        $header['activeColors'] = $totalColors > 0
            ? round(($activeColors / $totalColors) * 100, 2)
            : 0;

        return $header;
    }

    public function getColorFullInfo(Color $color)
    {
        $colorDTO = new ColorFullInfoDTO(
            id: $color->id,
            title: $color->title,
            hex: $color->hex,
            created_at: $color->created_at->translatedFormat('j F Yг.'),
            updated_at: $color->updated_at->translatedFormat('j F Yг.'),
            deleted_at: $color->deleted_at ? $color->deleted_at->translatedFormat('j F Yг.') : 'Не удален',
        );

        return $colorDTO;
    }
}
