<?php

namespace App\Filament\Fabricator\PageBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Z3d0X\FilamentFabricator\PageBlocks\PageBlock;

class Services extends PageBlock
{
    public static function getBlockSchema(): Block
    {
        return Block::make('services')
            ->schema([
                // Title Section
                TextInput::make('title')
                    ->label('Title')
                    ->required(),

                // Repeater with Image, Text, and Button
                Repeater::make('services_list')
                    ->label('Services')
                    ->columns(3) // This ensures 3 columns in the repeater
                    ->createItemButtonLabel('Add New Service') // Create button label
                    ->schema([
                        // File Upload for image
                        FileUpload::make('image')
                            ->label('Service Image')
                            ->image() // Ensure that only image files are uploaded
                            ->required(),

                        // Service Text
                        TextInput::make('text')
                            ->label('Service Text')
                            ->required(),

                        // Button URL
                        TextInput::make('button_url')
                            ->label('Button URL')
                            ->url()
                            ->required(),
                    ])
                    ->required(),
            ]);
    }

    public static function mutateData(array $data): array
    {
        return $data;
    }
}
