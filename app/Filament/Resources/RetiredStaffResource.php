<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RetiredStaffResource\Pages;
use App\Models\RetiredStaff;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class RetiredStaffResource extends Resource
{
    protected static ?string $model = RetiredStaff::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function canViewAny(): bool
    {
        return auth()->check() && strtolower(auth()->user()->role ?? '') !== 'chm';
    }
    protected static ?string $navigationLabel = 'Retired Staff';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Staff Information')
                    ->schema([
                        Forms\Components\TextInput::make('name_eng')->required(),
                        Forms\Components\TextInput::make('name_mal'),
                        Forms\Components\Textarea::make('address'),
                        Forms\Components\TextInput::make('district'),
                        Forms\Components\TextInput::make('pin'),
                        Forms\Components\TextInput::make('contact_no'),
                        Forms\Components\TextInput::make('kla_id'),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->disk('public')
                            ->label('Staff Photo')
                            ->image()
                            ->responsiveImages()
                            ->maxFiles(1)
                            ->imageEditor(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('images')
                    ->collection('images')
                    ->label('Photo')
                    ->conversion('thumb')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('name_eng')->searchable(),
                Tables\Columns\TextColumn::make('district'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListRetiredStaff::route('/'),
            'create' => Pages\CreateRetiredStaff::route('/create'),
            'edit' => Pages\EditRetiredStaff::route('/{record}/edit'),
        ];
    }
}
