<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Название программы')
                    ->required(),

                Select::make('university_id')
                    ->label('Университет')
                    ->relationship('university', 'name')
                    ->required(),

                TextInput::make('field_of_study')
                    ->label('Направление')
                    ->required(),

                Textarea::make('description')
                    ->label('Описание')
                    ->nullable(),

                Toggle::make('is_top')
                    ->label('Топ программа')
                    ->default(false),

                Toggle::make('is_active')
                    ->label('Активна')
                    ->default(true),

                Repeater::make('career_info')
                    ->label('Карьера')
                    ->schema([
                        TextInput::make('career')->label('Вариант карьеры'),
                    ])
                    ->columns(1)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
