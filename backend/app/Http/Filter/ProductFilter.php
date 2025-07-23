<?php

namespace App\Http\Filter;

use App\Http\Filter\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends AbstractFilter
{
    const CATEGORIES = 'categories';
    const COLORS = 'colors';
    const PRICES = 'prices';
    const TAGS = 'tags';

    protected function getCallbacks(): array
    {
        return
            [
                self::CATEGORIES => [$this, 'categories'],
                self::COLORS => [$this, 'colors'],
                self::TAGS => [$this, 'tags'],
                self::PRICES => [$this, 'prices'],
            ];
    }

    protected function categories(Builder $builder, $value)
    {
        $builder->where('category_id', $value);
    }

    protected function colors(Builder $builder, $value)
    {
        $builder->orWhereHas('colors', function ($b) use ($value) {
            $b->whereIn('color_id', $value);
        });
    }

    protected function prices(Builder $builder, $value)
    {
        $builder->whereBetween('price', $value);
    }

    protected function tags(Builder $builder, $value)
    {
        $builder->whereHas('tags', function ($b) use ($value) {
            $b->whereIn('tag_id', $value);
        });
    }
}
