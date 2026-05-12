<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HelpdeskTicketResource\Pages;
use App\Filament\Resources\HelpdeskTicketResource\RelationManagers;
use App\Models\HelpdeskTicket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HelpdeskTicketResource extends Resource
{
    protected static ?string $model = HelpdeskTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Helpdesk';
    protected static ?string $modelLabel = 'Helpdesk Ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ticket Information')
                    ->schema([
                        Forms\Components\TextInput::make('ticket_no')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('status')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\TextInput::make('employee_id')
                            ->label('Employee ID / Name'),
                        Forms\Components\TextInput::make('section'),
                        Forms\Components\Select::make('complaint_type')
                            ->options([
                                'Hardware' => 'Hardware',
                                'Software' => 'Software',
                                'Network' => 'Network',
                                'Printer' => 'Printer',
                                'Email' => 'Email',
                            ]),
                    ])->columns(2),
                Forms\Components\Section::make('Location Details')
                    ->schema([
                        Forms\Components\Select::make('office_location_id')
                            ->relationship('location', 'location')
                            ->label('Building'),
                        Forms\Components\TextInput::make('floor'),
                        Forms\Components\Select::make('room_id')
                            ->relationship('room', 'name')
                            ->label('Room'),
                    ])->columns(3),
                Forms\Components\Section::make('Problem & Resolution')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('technician_id')
                            ->relationship('technician', 'name')
                            ->label('Assigned Technician'),
                        Forms\Components\Textarea::make('remarks')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Ticket & Location Details')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('ticket_no')
                                    ->label('Ticket #')
                                    ->weight('bold')
                                    ->copyable(),
                                Infolists\Components\TextEntry::make('status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'Open' => 'danger',
                                        'Assigned' => 'warning',
                                        'In Progress', 'InProgress' => 'info',
                                        'Pending' => 'warning',
                                        'Complaint' => 'danger',
                                        'Resolved' => 'success',
                                        'Closed' => 'gray',
                                        default => 'secondary',
                                    }),
                                Infolists\Components\TextEntry::make('employee_id')
                                    ->label('Employee'),
                                Infolists\Components\TextEntry::make('section'),
                                Infolists\Components\TextEntry::make('complaint_type')
                                    ->label('Category'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Raised At')
                                    ->dateTime(),
                            ]),
                        Infolists\Components\ViewEntry::make('divider')
                            ->view('filament.helpdesk.divider')
                            ->columnSpanFull(),
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('location.location')
                                    ->label('Building'),
                                Infolists\Components\TextEntry::make('floor')
                                    ->label('Floor'),
                                Infolists\Components\TextEntry::make('room.name')
                                    ->label('Room'),
                                Infolists\Components\TextEntry::make('description')
                                    ->columnSpanFull()
                                    ->prose(),
                            ]),
                    ]),

                Infolists\Components\Section::make('Resolution Tracking')
                    ->schema([
                        Infolists\Components\ViewEntry::make('status_timeline')
                            ->hiddenLabel()
                            ->view('filament.helpdesk.timeline')
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('technician.name')
                            ->label('Assigned Technician')
                            ->placeholder('Not assigned yet'),
                        Infolists\Components\TextEntry::make('remarks')
                            ->label('Final Resolution Remarks')
                            ->placeholder('No remarks provided')
                            ->columnSpanFull(),
                    ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_no')
                    ->label('Ticket #')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Open' => 'danger',
                        'Assigned' => 'warning',
                        'In Progress', 'InProgress' => 'info',
                        'Pending' => 'warning',
                        'Complaint' => 'danger',
                        'Resolved' => 'success',
                        'Closed' => 'gray',
                        default => 'secondary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Requested By')
                    ->searchable(),
                Tables\Columns\TextColumn::make('section')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.location')
                    ->label('Building')
                    ->sortable(),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('Room')
                    ->sortable(),
                Tables\Columns\TextColumn::make('complaint_type')
                    ->label('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Technician')
                    ->placeholder('Unassigned')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Raised At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Open' => 'Open',
                        'Assigned' => 'Assigned',
                        'InProgress' => 'In Progress',
                        'Pending' => 'Pending',
                        'Complaint' => 'Complaint',
                        'Resolved' => 'Resolved',
                    ]),
                Tables\Filters\SelectFilter::make('complaint_type')
                    ->options([
                        'Hardware' => 'Hardware',
                        'Software' => 'Software',
                        'Network' => 'Network',
                        'Printer' => 'Printer',
                        'Email' => 'Email',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->hiddenLabel(),
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-m-pencil')
                    ->color('warning')
                    ->hiddenLabel(),
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
            RelationManagers\StatusHistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHelpdeskTickets::route('/'),
            'create' => Pages\CreateHelpdeskTicket::route('/create'),
            'view' => Pages\ViewHelpdeskTicket::route('/{record}'),
            'edit' => Pages\EditHelpdeskTicket::route('/{record}/edit'),
        ];
    }
}
