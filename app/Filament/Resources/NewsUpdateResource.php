<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsUpdateResource\Pages;
use App\Filament\Resources\NewsUpdateResource\RelationManagers;
use App\Models\NewsUpdate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsUpdateResource extends Resource
{
    protected static ?string $model = NewsUpdate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date'),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('path')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])

                    ->maxSize(1048576) // 1GB (1024MB)
                    ->disk('public')
                    ->directory(function (callable $get) {
                        $year = $get('date') ? date('Y', strtotime($get('date'))) : date('Y');
                        return "uploads/news/{$year}";
                    })
                    ->openable()

                    ->afterStateUpdated(function ($state, $record, callable $set) {
                        // Delete old file when a new one is uploaded
                        if ($record && $record->path && $state && Storage::disk('public')->exists($record->path)) {
                            Storage::disk('public')->delete($record->path);
                            $set('path', $state);
                        }
                    }),
                Forms\Components\Select::make('status')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->required()
                    ->default('0'),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#') // Add serial number column
                    ->label('S.No') // Label for the column
                    ->rowIndex(), // Automatically generates a serial number
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('path')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
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
                 Tables\Filters\SelectFilter::make('status')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('')
                    ->icon('heroicon-s-eye')
                    ->modalHeading(fn($record) => 'View News Update: ' . $record->title)
                    ->modalContent(function ($record) {
                        $url = \Storage::disk('public')->url($record->path);
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
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
              ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListNewsUpdates::route('/'),
            'create' => Pages\CreateNewsUpdate::route('/create'),
            'edit' => Pages\EditNewsUpdate::route('/{record}/edit'),
        ];
    }
}
