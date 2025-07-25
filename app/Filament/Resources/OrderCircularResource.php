<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCircularResource\Pages;
use App\Filament\Resources\OrderCircularResource\RelationManagers;
use App\Models\OrderCircular;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class OrderCircularResource extends Resource
{
    protected static ?string $model = OrderCircular::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function form(Form $form): Form
    {
        $excludeKeywords = ['office', 'js', 'joint', 'deputy', 'as', 'special', 'librarian', 'chief', 'e-niyamasabha'];
        return $form
            ->schema([
                Forms\Components\Select::make('section_id')
                    ->relationship(
                        name: 'sections',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query) use ($excludeKeywords) {
                            foreach ($excludeKeywords as $keyword) {
                                $query->where('name', 'not like', '%' . $keyword . '%');
                            }
                            return $query;
                        }
                    ),
                Forms\Components\Select::make('type')
                    ->options([
                        'G' => 'Govt Order',
                        'O' => 'Office Order',
                        'C' => 'Circular',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        // Reset dependent fields when type changes
                        if ($state !== 'G') {
                            $set('go_type', null);
                        }
                        if ($state !== 'O') {
                            $set('sub_type', 'Service');
                        }
                        if ($state === 'C') {
                            $set('sub_type', null);
                            $set('sub_sub_type', null);
                        }
                    }),
                Forms\Components\Select::make('go_type')
                    ->options([
                        'M' => 'സർക്കാർ ഉത്തരവുകൾ കയ്യെഴുത്തു (Govt.Order Manuscript)',
                        'R' => 'സർക്കാർ ഉത്തരവുകൾ സാധാ (Govt.Order Routine)',
                        'P' => 'സർക്കാർ ഉത്തരവുകൾ അച്ചടി (Govt.Order Print)',
                    ])
                    ->required()
                    ->visible(fn(callable $get) => $get('type') === 'G')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('sub_type', null);
                        $set('sub_sub_type', null);
                    }),
                Forms\Components\Select::make('sub_type')
                    ->label('Service / Member Related')
                    ->options([
                        'Service' => 'Service Related',
                        'Member' => 'Members Related',
                    ])
                    // ->required()
                    ->visible(fn(callable $get) => in_array($get('go_type'), ['M', 'R', 'P']) || $get('type') === 'O')
                    ->reactive()
                    ->default('Service')
                    ->afterStateUpdated(function (callable $set) {
                        $set('sub_sub_type', null);
                    }),
                Forms\Components\Select::make('sub_sub_type')
                    ->label('Category')
                    ->options(function (callable $get) {
                        $type = $get('type');
                        $options = [
                            'CR' => 'Claim / Reimbursements',
                            'TP' => 'Transfer & Posting',
                            'PA' => 'PA Postings',
                            'AR' => 'Accounts Related',
                            'G' => 'General',
                        ];
                        // Remove PA option if type is Circular
                        if ($type === 'C') {
                            unset($options['PA']);
                        }
                        return $options;
                    })
                    ->required()
                    ->visible(fn(callable $get) => in_array($get('sub_type'), ['Service', 'Member']) || $get('type') === 'C')
                    ->reactive(),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('keywords')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('path')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024000) // 1GB max size (matching controller validation)
                    ->disk('public')
                    ->directory(function (callable $get) {
                        $year = $get('date') ? date('Y', strtotime($get('date'))) : date('Y');
                        $categoryFolder = match ($get('type')) {
                            'G' => 'GovtOrders',
                            'O' => 'OfficeOrders',
                            'C' => 'Circulars',
                            default => 'Others',
                        };
                        return "uploads/orders-circular/{$year}/{$categoryFolder}";
                    })
                    ->openable()
                    ->afterStateUpdated(function ($state, $record, callable $set) {
                        // Delete old file when a new one is uploaded
                        if ($record && $record->path && $state && Storage::disk('public')->exists($record->path)) {
                            Storage::disk('public')->delete($record->path);
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

                Tables\Columns\TextColumn::make('sections.name')
                    ->label('Section')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'G' => 'Govt Order',
                            'O' => 'Office Order',
                            'C' => 'Circular',
                            default => $state,
                        };
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('go_type')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'M' => 'സ.ഉ.കയ്യെഴുത്തു (GO.Manuscript)',
                            'R' => 'സ.ഉ.സാധാ (GO.Routine)',
                            'P' => 'സ.ഉ.അച്ചടി (GO.Print)',
                            default => $state ?: '-',
                        };
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_type')
                    ->label('Service/Member')
                    ->formatStateUsing(fn($state) => $state ?: '-')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_sub_type')
                    ->label('Category')
                    ->formatStateUsing(fn($state) => $state ?: '-')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('keywords')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->formatStateUsing(fn($state) => $state == '1' ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-danger">Unpublished</span>')
                    ->html()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title_length')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('error_type')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'G' => 'Govt Order',
                        'O' => 'Office Order',
                        'C' => 'Circular',
                    ])
                    ->label('Type'),
                Tables\Filters\SelectFilter::make('go_type')
                    ->options([
                        'M' => 'സ.ഉ.കയ്യെഴുത്തു (GO.Manuscript)',
                        'R' => 'സ.ഉ.സാധാ (GO.Routine)',
                        'P' => 'സ.ഉ.അച്ചടി (GO.Print)',
                    ])
                    ->label('GO Type'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->label('Status'),
                Tables\Filters\SelectFilter::make('section_id')
                    ->relationship('sections', 'name')
                    ->label('Section')
                    ->preload()
                    ->searchable(),
                Tables\Filters\Filter::make('title_length')
                    ->label('Title Length < 50')
                    ->query(function ($query) {
                        return $query->whereRaw('CHAR_LENGTH(title) < 50');
                    })
                    ->toggle(),



            ])
            ->actions([
                Tables\Actions\Action::make('view_pdf')
                    ->label('')
                    ->icon('heroicon-s-eye')
                    ->modalHeading(fn($record) => 'View PDF: ' . $record->title)
                    ->modalContent(function ($record) {
                        $url = \Illuminate\Support\Facades\Storage::url($record->path);
                        return new \Illuminate\Support\HtmlString(
                            '<div style="height: 90vh; padding: 1rem; overflow: auto;">' .
                                view('filament.pdf-modal', ['url' => $url])->render() .
                                '</div>'
                        );
                    })
                    ->modalSubmitAction(false) // Remove the default "Submit" button
                    ->modalCancelActionLabel('Close') // Label for the close button
                    ->modalWidth('5xl'), // Set the modal width (adjust as needed)
                Tables\Actions\EditAction::make()
                    ->label('') // Remove the label
                    ->color('warning'), // Sets button to yellow (Tailwind text-yellow-500)


                Tables\Actions\DeleteAction::make()
                    ->label('') // Remove the label
                    ->before(function ($record) {
                        // Delete associated file before deleting record
                        if ($record->path && Storage::disk('public')->exists($record->path)) {
                            Storage::disk('public')->delete($record->path);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->before(function ($records) {
                        // Delete associated files before deleting records
                        foreach ($records as $record) {
                            if ($record->path && Storage::disk('public')->exists($record->path)) {
                                Storage::disk('public')->delete($record->path);
                            }
                        }
                    }),
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
            'index' => Pages\ListOrderCirculars::route('/'),
            'create' => Pages\CreateOrderCircular::route('/create'),
            'edit' => Pages\EditOrderCircular::route('/{record}/edit'),
        ];
    }
}
