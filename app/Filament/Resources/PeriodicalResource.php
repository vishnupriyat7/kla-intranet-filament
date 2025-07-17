<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeriodicalResource\Pages;
use App\Filament\Resources\PeriodicalResource\RelationManagers;
use App\Models\Periodical;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\PeriodicalMaster;
use Illuminate\Support\Facades\Storage;

class PeriodicalResource extends Resource
{
    protected static ?string $model = Periodical::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('periodical_master_id')
                    ->required()
                    ->relationship('periodicalMaster', 'name'),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                // Forms\Components\TextInput::make('path')
                //     ->required()
                //     ->maxLength(255),
                Forms\Components\FileUpload::make('path')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240) // 10MB max size
                    ->directory('uploads/periodicals/pdf')
                    ->disk('public')
                    ->openable() // Updated to use openable() instead of enableOpen()
                    ->afterStateUpdated(function ($state, $record, callable $set) {
                        // Delete the old file if it exists and a new file is uploaded
                        if ($record && $record->path && $state && Storage::disk('public')->exists($record->path)) {
                            Storage::disk('public')->delete($record->path);
                        }
                    }),
                Forms\Components\Textarea::make('keywords')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->required()
                    ->default(0),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#') // Add serial number column
                    ->label('S.No') // Label for the column
                    ->rowIndex(), // Automatically generates a serial number
                Tables\Columns\TextColumn::make('periodicalMaster.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('path')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\Action::make('view_pdf')
                    ->label('')
                    ->icon('heroicon-s-eye')
                    ->modalHeading(fn($record) => 'View PDF: ' . $record->periodicalMaster->name)
                    ->modalContent(function ($record) {
                        $url = \Storage::disk('public')->url($record->path);
                        // \Log::info('PDF Modal URL: ' . $url);
                        return new \Illuminate\Support\HtmlString(
                            '<div style="height: 80vh; padding: 1rem; overflow: auto;">' .
                                view('filament.pdf-modal', ['url' => $url])->render() .
                                '</div>'
                        );
                    })
                    ->modalSubmitAction(false) // Remove the default "Submit" button
                    ->modalCancelActionLabel('Close') // Label for the close button
                    ->modalWidth('5xl'), // Set the modal width (adjust as needed)

                Tables\Actions\EditAction::make()
                    ->label('') // Remove the labe
                    ->color('warning'),

                Tables\Actions\DeleteAction::make()
                    ->label(''), // Remove the label

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
            'index' => Pages\ListPeriodicals::route('/'),
            'create' => Pages\CreatePeriodical::route('/create'),
            'edit' => Pages\EditPeriodical::route('/{record}/edit'),
        ];
    }
}
