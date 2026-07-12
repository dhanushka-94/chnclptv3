<?php

namespace App\View\Composers;

use App\Services\PerformanceCacheService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CategoryComposer
{
    public function compose(View $view): void
    {
        $menuCategories = Cache::remember(
            'menu_categories_top12',
            PerformanceCacheService::CATEGORY_CACHE_DURATION,
            function () {
                return \App\Models\SmaCategory::where(function ($q) {
                    $q->whereNull('parent_id')
                        ->orWhere('parent_id', '')
                        ->orWhere('parent_id', 0);
                })
                    ->with(['subcategories' => function ($query) {
                        $query->withCount(['subcategoryProducts'])
                            ->having('subcategory_products_count', '>', 0)
                            ->orderBy('name');
                    }])
                    ->withCount('products')
                    ->having('products_count', '>', 0)
                    ->orderBy('products_count', 'desc')
                    ->take(12)
                    ->get();
            }
        );

        $view->with('menuCategories', $menuCategories);
    }
}
