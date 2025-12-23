<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserDocumentResource\Pages;
use App\Models\UserDocument;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserDocumentResource extends Resource
{
    protected static ?string $model = UserDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
            'index' => Pages\ListUserDocuments::route('/'),
            'create' => Pages\CreateUserDocument::route('/create'),
            'edit' => Pages\EditUserDocument::route('/{record}/edit'),
        ];
    }
}
