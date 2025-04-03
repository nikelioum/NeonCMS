<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;
use Rmsramos\Activitylog\Actions\ActivityLogTimelineTableAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('roles')
                ->label('Role')
                ->relationship('roles', 'name') // Spatie Role Relationship
                ->multiple()
                ->preload()
                ->searchable()
                ->required(),

            Forms\Components\Fieldset::make('Password')
                ->schema([
                    Forms\Components\Toggle::make('change_password')
                        ->label('Change Password?')
                        ->reactive()
                        ->hidden(fn ($livewire) => $livewire instanceof \App\Filament\Resources\UserResource\Pages\CreateUser), // Hide in Create

                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->maxLength(255)
                        ->hidden(fn ($get, $livewire) => 
                            !$get('change_password') && $livewire instanceof \App\Filament\Resources\UserResource\Pages\EditUser // Corrected this line
                        ) // Hide unless toggle is enabled in Edit
                        ->required(fn ($livewire) => $livewire instanceof \App\Filament\Resources\UserResource\Pages\CreateUser) // Required in Create
                        ->nullable(),
                ]),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name') // Display Role
                    ->label('Role')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ActivityLogTimelineTableAction::make('Activities')
                ->timelineIcons([
                    'created' => 'heroicon-m-check-badge',
                    'updated' => 'heroicon-m-pencil-square',
                ])
                ->timelineIconColors([
                    'created' => 'info',
                    'updated' => 'warning',
                ])
                ->limit(10),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
