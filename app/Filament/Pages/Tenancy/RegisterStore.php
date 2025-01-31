<?php

declare(strict_types=1);

namespace App\Filament\Pages\Tenancy;

use App\Models\Store;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class RegisterStore extends RegisterTenant
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getLabel(): string
    {
        return 'Create Store';
    }

    public function mount(): void
    {
        parent::mount();
    }

    public function form(Form $form): Form
    {
        $user = Auth::user();

        if ($user === null) {
            abort(403, 'You must be logged in to register a new store.');
        }

        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->default(Filament::getUserName($user).'\'s Store'),
            ]);
    }

    protected function handleRegistration(array $data): Store
    {
        $user = Auth::user();

        if ($user === null) {
            abort(403, 'You must be logged in to register a new store.');
        }

        if (! is_string($data['name'] ?? null)) {
            abort(400, 'The store name must be a string.');
        }

        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = $user->id;

        $store = Store::create($data);

        $user->update(['store_id' => $store->id]);

        return $store;
    }
}
