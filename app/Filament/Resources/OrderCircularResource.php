<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCircularResource\Pages;
use App\Models\OrderCircular;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters;
use Filament\Tables\Actions;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\Radio;

class OrderCircularResource extends Resource
{
    protected static ?string $model = OrderCircular::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    public static function canViewAny(): bool
    {
        return auth()->check() && !in_array(strtolower(auth()->user()->role ?? ''), ['chm', 'hardwareadmin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('section_id')
                    ->relationship(
                        name: 'sections',
                        titleAttribute: 'name',
                        modifyQueryUsing: function ($query) {
                            $query->where('status', 1);
                            return $query;
                        }
                    ),
                Select::make('type')
                    ->options([
                        'G' => 'Govt Order',
                        'O' => 'Office Order',
                        'C' => 'Circular',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
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
                Select::make('go_type')
                    ->label('Go Type')
                    ->options([
                        'M' => 'സ.ഉ. കയ്യെഴുത്തു (G.O Manuscript)',
                        'R' => 'സ.ഉ. സാധാ (G.O Routine)',
                        'P' => 'സ.ഉ. അച്ചടി (G.O Print)',
                    ])
                    ->required()
                    ->visible(fn(callable $get) => $get('type') === 'G')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set) {
                        $set('sub_type', null);
                        $set('sub_sub_type', null);
                    }),
                Select::make('sub_type')
                    ->relationship(
                        name: 'category',
                        titleAttribute: 'name',
                    ),
                Select::make('sub_sub_type')
                    ->relationship(
                        name: 'subcategory',
                        titleAttribute: 'name',
                    ),
                TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Components\DatePicker::make('date')
                    ->required(),
                Textarea::make('title')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('link')
                    ->label('Link (If Any)')
                    ->columnSpanFull(),
                Radio::make('title_lingo')
                    ->label('Title Language')
                    ->options([
                        'E' => 'English',
                        'M' => 'Malayalam'
                    ])
                    ->inline()
                    ->required(),
                Select::make('tags')
                    ->label('Order Related To (Multiple Selection)')
                    ->options(Tag::all()->pluck('phrase', 'id'))
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $names = Tag::whereIn('id', $state)->pluck('phrase')->toArray();
                        $set('keywords', implode(', ', $names));
                    }),
                Textarea::make('keywords')
                    ->label('Keywords (If any)'),
                // Components\FileUpload::make('path')
                //     ->required()
                //     ->acceptedFileTypes(['application/pdf'])
                //     ->maxSize(1024000) // 1GB max size (matching controller validation)
                //     ->disk('public')
                //     ->directory(function (callable $get) {
                //         $year = $get('date') ? date('Y', strtotime($get('date'))) : date('Y');
                //         $categoryFolder = match ($get('type')) {
                //             'G' => 'GovtOrders',
                //             'O' => 'OfficeOrders',
                //             'C' => 'Circulars',
                //             default => 'Others',
                //         };
                //         return "uploads/orders-circular/{$year}/{$categoryFolder}";
                //     })
                //     ->openable()
                //     ->afterStateUpdated(function ($state, $record, callable $set) {
                //         // Delete old file when a new one is uploaded
                //         if ($record && $record->path && $state && Storage::disk('public')->exists($record->path)) {
                //             Storage::disk('public')->delete($record->path);
                //         }
                //     }),
                Components\FileUpload::make('path')
                    ->label('Upload Files (PDF)')
                    ->multiple()
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(1024000) // 1GB per file
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
                    ->downloadable()
                    ->reorderable()
                    ->afterStateUpdated(function ($state, $record) {
                        // Delete removed old files
                        if ($record && is_array($record->path)) {
                            $deleted = array_diff($record->path, $state ?? []);
                            foreach ($deleted as $file) {
                                if (Storage::disk('public')->exists($file)) {
                                    Storage::disk('public')->delete($file);
                                }
                            }
                        }
                    }),

                Select::make('status')
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
                TextColumn::make('#') // Add serial number column
                    ->label('S.No') // Label for the column
                    ->rowIndex(), // Automatically generates a serial number
                TextColumn::make('sections.name')
                    ->label('Section')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
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
                TextColumn::make('go_type')
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
                TextColumn::make('category.name')
                    ->label('Category')
                    ->formatStateUsing(fn($state) => $state ?: '-')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('subcategory.name')
                    ->label('Sub Category')
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'G' => 'General',
                            'CR' => 'Claim / Reimbersment',
                            'TP' => 'Transfer & Posting',
                            default => $state ?: '-',
                        };
                    })
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('link')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('keywords')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('path')
                //     ->searchable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('path')
                    ->label('Files')
                    ->formatStateUsing(function ($state) {
                        if (!$state || !is_array($state)) return '-';

                        return collect($state)->map(function ($file) {
                            $url = Storage::url($file);
                            return "<a href='{$url}' target='_blank' class='text-primary'>View PDF</a>";
                        })->implode('<br>');
                    })
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => $state == '1' ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-danger">Unpublished</span>')
                    ->html()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title_length')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('error_type')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updatedBy.name')
                    ->label('Updated By')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($state) => $state ?? 'N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'G' => 'Govt Order',
                        'O' => 'Office Order',
                        'C' => 'Circular',
                    ])
                    ->label('Type'),
                SelectFilter::make('go_type')
                    ->options([
                        'M' => 'സ.ഉ.കയ്യെഴുത്തു (GO.Manuscript)',
                        'R' => 'സ.ഉ.സാധാ (GO.Routine)',
                        'P' => 'സ.ഉ.അച്ചടി (GO.Print)',
                    ])
                    ->label('GO Type'),
                // Year-wise filter
                SelectFilter::make('year')
                    ->options(function () {
                        $years = \Illuminate\Support\Facades\DB::table('order_circulars')
                            ->selectRaw('YEAR(date) as year')
                            ->whereNotNull('date')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year')
                            ->mapWithKeys(function ($year) {
                                return [$year => (string) $year];
                            })
                            ->toArray();
                        return $years;
                    })
                    ->label('Year')
                    ->query(function ($query, $data) {
                        if ($data['value']) {
                            $query->whereYear('date', $data['value']);
                        }
                    }),
                SelectFilter::make('month')
                    ->options([
                        '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'August',
                        '9' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December',
                    ])
                    ->label('Month')
                    ->query(function ($query, $data) {
                        if ($data['value']) {
                            $query->whereMonth('date', $data['value']);
                        }
                    }),
                SelectFilter::make('status')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Unpublished',
                    ])
                    ->label('Status'),
                SelectFilter::make('section_id')
                    ->relationship('sections', 'name')
                    ->label('Section')
                    ->preload()
                    ->searchable(),
                Filters\Filter::make('title_length')
                    ->label('Title Length < 50')
                    ->query(function ($query) {
                        return $query->whereRaw('CHAR_LENGTH(title) < 50');
                    })
                    ->toggle(),
            ])
            ->actions([
                Actions\Action::make('view_pdf')
                    // ->label('')
                    // ->icon('heroicon-s-eye')
                    // ->modalHeading(fn($record) => 'View PDF: ' . $record->title)
                    // ->modalContent(function ($record) {
                    //     $url = Storage::url($record->path);
                    //     return new \Illuminate\Support\HtmlString(
                    //         '<div style="height: 90vh; padding: 1rem; overflow: auto;">' .
                    //             view('filament.pdf-modal', ['url' => $url])->render() .
                    //             '</div>'
                    //     );
                    // })
                    // ->modalSubmitAction(false) // Remove the default "Submit" button
                    // ->modalCancelActionLabel('Close') // Label for the close button
                    // ->modalWidth('5xl'), // Set the modal width (adjust as needed)
                    ->icon('heroicon-s-eye')
                    ->modalHeading(fn($record) => 'View PDFs: ' . $record->title)
                    ->modalContent(function ($record) {
                        if (!$record->path) return 'No files available';

                        return new \Illuminate\Support\HtmlString(
                            collect($record->path)->map(function ($file) {
                                $url = Storage::url($file);
                                return view('filament.pdf-modal', ['url' => $url])->render();
                            })->implode('<hr>')
                        );
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('5xl'),
                Actions\EditAction::make()
                    ->label('') // Remove the label
                    ->color('warning'), // Sets button to yellow (Tailwind text-yellow-500)
                Actions\DeleteAction::make()
                    ->label('') // Remove the label
                    ->before(function ($record) {
                        if (is_array($record->path)) {
                            foreach ($record->path as $file) {
                                if (Storage::disk('public')->exists($file)) {
                                    Storage::disk('public')->delete($file);
                                }
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make()
                    ->before(function ($records) {
                        foreach ($records as $record) {
                            if (is_array($record->path)) {
                                foreach ($record->path as $file) {
                                    if (Storage::disk('public')->exists($file)) {
                                        Storage::disk('public')->delete($file);
                                    }
                                }
                            }
                        }
                    })

            ])
            ->defaultSort('date', 'desc')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->persistSortInSession();
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
