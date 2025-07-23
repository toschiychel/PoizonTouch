<?php

namespace App\Services\AdminPanel\Tag;

use App\DTO\Tag\TagFullInfoDTO;
use App\Models\Tag;

class TagService
{
    public function getPaginatedTags(int $perPage)
    {
        return Tag::paginate($perPage);
    }

    public function getHeaderInfo()
    {
        $header = [];

        $totalTags = Tag::count();
        $activeTags = Tag::has('products')->count();

        $header['count'] = $totalTags;

        $header['activeTags'] = $totalTags > 0
            ? round(($activeTags / $totalTags) * 100, 2)
            : 0;

        return $header;
    }

    public function getTagFullInfo(Tag $tag)
    {
        $tagDTO = new TagFullInfoDTO(
            id: $tag->id,
            title: $tag->title,
            created_at: $tag->created_at->translatedFormat('j F Yг.'),
            updated_at: $tag->updated_at->translatedFormat('j F Yг.'),
            deleted_at: $tag->deleted_at ? $tag->deleted_at->translatedFormat('j F Yг.') : 'Не удален',
        );

        return $tagDTO;
    }
}
