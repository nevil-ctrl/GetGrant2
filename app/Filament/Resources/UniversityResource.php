<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniversityResource\Pages;
use App\Models\University;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UniversityResource extends Resource
{
    protected static ?string $model = University::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название университета')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),

                        Select::make('country_id')
                            ->label('Страна')
                            ->relationship('country', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('level')
                            ->label('Уровень обучения')
                            ->options([
                                'bachelor' => 'Бакалавриат',
                                'master' => 'Магистратура',
                                'phd' => 'PhD',
                                'all' => 'Все уровни',
                            ])
                            ->default('all')
                            ->required(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->nullable()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Контакты и ссылки')
                    ->schema([
                        TextInput::make('logo')
                            ->label('Логотип (URL)')
                            ->url()
                            ->nullable()
                            ->columnSpan(1),

                        TextInput::make('website')
                            ->label('Веб-сайт')
                            ->url()
                            ->nullable()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Стоимость обучения')
                    ->schema([
                        TextInput::make('cost_min')
                            ->label('Минимальная стоимость ($)')
                            ->numeric()
                            ->nullable()
                            ->columnSpan(1),

                        TextInput::make('cost_max')
                            ->label('Максимальная стоимость ($)')
                            ->numeric()
                            ->nullable()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Настройки')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Активен')
                            ->default(true)
                            ->helperText('Неактивные университеты не отображаются на сайте'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Страна')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit' => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
