<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UniversityResource\Pages;
use App\Models\University;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                TextInput::make('name')
                    ->label('University Name')
                    ->required(),

                Select::make('country_id')
                    ->label('Country')
                    ->relationship('country', 'name')
                    ->required(),

                Textarea::make('description')->label('Description')->nullable(),

                TextInput::make('logo')->label('Logo URL')->nullable(),
                TextInput::make('website')->label('Website')->nullable(),

                TextInput::make('cost_min')->label('Min Cost')->numeric()->nullable(),
                TextInput::make('cost_max')->label('Max Cost')->numeric()->nullable(),

                Select::make('level')

                    ->options([
                        'bachelor' => 'Bachelor',
                        'master' => 'Master',
                        'phd' => 'PhD',
                        'all' => 'All',
                    ])
                    ->default('all'),

                Select::make('is_active')
                    ->label('Active')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])
                    ->default(1),
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
            'index' => Pages\ListUniversities::route('/'),
            'create' => Pages\CreateUniversity::route('/create'),
            'edit' => Pages\EditUniversity::route('/{record}/edit'),
        ];
    }
}
