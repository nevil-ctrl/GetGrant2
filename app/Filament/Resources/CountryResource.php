<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Название страны'),

                TextInput::make('code')
                    ->required()
                    ->label('ISO код'),

                TextInput::make('flag')
                    ->label('Флаг (URL)')
                    ->nullable(),

                Textarea::make('description')
                    ->label('Описание')
                    ->nullable(),

                Repeater::make('selling_points')
                    ->label('Преимущества')
                    ->schema([
                        TextInput::make('value')
                            ->label('Преимущество')
                            ->required(),
                    ])
                    ->columns(1)
                    ->nullable(),

                Toggle::make('is_active')
                    ->label('Активна')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Название')->sortable()->searchable(),
                TextColumn::make('code')->label('ISO код')->sortable()->searchable(),
                BooleanColumn::make('is_active')->label('Активна'),
                TextColumn::make('created_at')->label('Создано')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
