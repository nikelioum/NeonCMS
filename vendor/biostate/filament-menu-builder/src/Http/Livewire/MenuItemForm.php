<?php

namespace Biostate\FilamentMenuBuilder\Http\Livewire;

use Biostate\FilamentMenuBuilder\Filament\Resources\MenuItemResource;
use Biostate\FilamentMenuBuilder\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class MenuItemForm extends Component implements HasForms
{
    use InteractsWithForms;

    public int $menuId;

    public ?array $data = [];

    public function mount(int $menuId): void
    {
        $this->menuId = $menuId;

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Menu Item')
                    ->description('Create New Menu Item')
                    ->schema(MenuItemResource::getFormSchema())
                    ->footerActions([
                        Action::make('submit')
                            ->label(__('filament-menu-builder::menu-builder.create_menu_item'))
                            ->submit('submit'),
                    ]),
            ])
            ->operation('create')
            ->statePath('data');
    }

    public function submit(): void
    {
        $menuItem = array_merge($this->data, [
            'menu_id' => $this->menuId,
        ]);

        $menuItem = MenuItem::query()->create($menuItem);

        $this->form->fill();

        $this->dispatch('menu-item-created', menuId: $this->menuId, menuItemId: $menuItem->id);
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    public function render()
    {
        return view('filament-menu-builder::livewire.menu-item-form');
    }
}
