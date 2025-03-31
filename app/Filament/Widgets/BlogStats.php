<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Support\Enums\Alignment;

class BlogStats extends BaseWidget
{
    protected function getHeading(): string
    {
        return 'Blog Overview';
    }

    protected function getCards(): array
    {
        return [
            Card::make('Categories', Category::count())
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='" . route('filament.admin.resources.categories.index') . "'",
                ]),

            Card::make('Tags', Tag::count())
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='" . route('filament.admin.resources.tags.index') . "'",
                ]),

            Card::make('Posts', Post::count())
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                    'onclick' => "window.location.href='" . route('filament.admin.resources.posts.index') . "'",
                ]),
        ];
    }
}
