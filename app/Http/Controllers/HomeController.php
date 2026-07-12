<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $categories = \App\Services\PerformanceCacheService::getMainCategories()
            ->filter(fn ($category) => ($category->active_products_count ?? 0) > 0)
            ->take(8);

        $promoDeals = \App\Services\PerformanceCacheService::getPromotionProducts(null, 4);
        $categorySections = \App\Services\PerformanceCacheService::getHomepageProductsByCategory(5);
        $heroSlides = $this->resolveHeroSlides($promoDeals);

        return view('home', compact('categories', 'promoDeals', 'categorySections', 'heroSlides'));
    }

    private function resolveHeroSlides($promoDeals)
    {
        $slides = collect(config('homepage.hero_slides', []))
            ->filter(fn ($slide) => ! empty($slide['image']) && file_exists(public_path($slide['image'])))
            ->map(fn ($slide) => [
                'image' => asset($slide['image']),
                'url' => ! empty($slide['route']) ? route($slide['route']) : null,
                'alt' => $slide['alt'] ?? 'Chance Laptops',
            ])
            ->values();

        if ($slides->isNotEmpty()) {
            return $slides;
        }

        return $promoDeals->map(function ($product) {
            $url = $product->category
                ? route('products.show', [
                    'category' => $product->category->slug ?: $product->category->id,
                    'product' => $product->slug ?: $product->id,
                ])
                : route('promotions.index');

            return [
                'image' => $product->main_image,
                'url' => $url,
                'alt' => $product->name,
            ];
        })->values();
    }
}
