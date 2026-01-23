<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
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
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Название страны')
                            ->maxLength(255),

                        TextInput::make('code')
                            ->required()
                            ->label('ISO код (например: US, GB, DE)')
                            ->maxLength(2)
                            ->uppercase(),

                        TextInput::make('flag')
                            ->label('Флаг (эмодзи или URL)')
                            ->placeholder('🇺🇸')
                            ->nullable(),

                        Textarea::make('description')
                            ->label('Краткое описание')
                            ->nullable()
                            ->rows(3)
                            ->maxLength(500),
                    ])
                    ->columns(2),

                Section::make('Подробное описание')
                    ->schema([
                        Textarea::make('description_ru')
                            ->label('Описание на русском')
                            ->nullable()
                            ->rows(15)
                            ->columnSpanFull()
                            ->helperText('Полное описание страны для поступления'),

                        Textarea::make('description_en')
                            ->label('Описание на английском')
                            ->nullable()
                            ->rows(15)
                            ->columnSpanFull()
                            ->helperText('Full description in English'),
                    ]),

                Section::make('Преимущества')
                    ->schema([
                        Repeater::make('selling_points')
                            ->label('Преимущества (selling points)')
                            ->schema([
                                TextInput::make('value')
                                    ->label('Преимущество')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columns(1)
                            ->nullable()
                            ->helperText('Например: "№1 по безопасности", "Бесплатное обучение"'),
                    ]),

                Section::make('Настройки')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true)
                            ->helperText('Неактивные страны не отображаются на сайте'),
                    ]),
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
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50, 100]); // Пагинация для производительности
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
