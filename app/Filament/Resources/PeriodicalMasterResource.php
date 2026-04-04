<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodicalMasterResource\Pages;
use App\Filament\Resources\PeriodicalMasterResource\RelationManagers;
use App\Models\PeriodicalMaster;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage; // Add this import

class PeriodicalMasterResource extends Resource
{
    protected static ?string $model = PeriodicalMaster::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Periodical Management';

    public static function canViewAny(): bool
    {
        return auth()->check() && strtolower(auth()->user()->role ?? '') !== 'chm';
    }
    protected static ?string $navigationLabel = 'Masters';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('img')
                    ->required()
                    ->disk('public') // Store the file in the public disk
                    ->directory('uploads/periodicals') // Directory within the disk
                    ->preserveFilenames() // Optional: Preserve the original filename
                    ->acceptedFileTypes(['image/*']) // Accept only image files
                    ->maxSize(1024 * 5)
                    ->image() // Max file size: 5 MB
                    ->imageEditor()
                    ->openable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#') // Add serial number column
                    ->label('S.No') // Label for the column
                    ->rowIndex(), // Automatically generates a serial number
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('img')
                    ->disk('public')
                    ->size(50)
                    ->circular()
                    ->defaultImageUrl(url('images/default-placeholder.png')),// Fallback if image is missing
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->color('warning'),
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
            'index' => Pages\ListPeriodicalMasters::route('/'),
            'create' => Pages\CreatePeriodicalMaster::route('/create'),
            'edit' => Pages\EditPeriodicalMaster::route('/{record}/edit'),
        ];
    }
}
