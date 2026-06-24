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
use Illuminate\Support\Facades\Http;

class HelpdeskTicketResource extends Resource
{
    protected static ?string $model = HelpdeskTicket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Helpdesk';
    protected static ?string $modelLabel = 'Helpdesk Ticket';
    protected static ?int $navigationSort = 1;

    protected static $employeeCache = null;

    public static function resolveEmployeeName($employeeId)
    {
        if (!$employeeId)
            return '-';

        // If it's a name (contains letters), return as is
        if (preg_match('/[a-zA-Z]/', $employeeId))
            return $employeeId;

        if (static::$employeeCache === null) {
            try {
                $response = Http::get(env('EMPLOYEE_API_URL'));
                if ($response->successful()) {
                    static::$employeeCache = collect($response->json());
                } else {
                    static::$employeeCache = collect([]);
                }
            } catch (\Exception $e) {
                static::$employeeCache = collect([]);
            }
        }

        $employee = static::$employeeCache->first(function ($emp) use ($employeeId) {
            return (string) ($emp['pen'] ?? '') === (string) $employeeId ||
                (string) ($emp['attendanceId'] ?? '') === (string) $employeeId;
        });

        return $employee ? $employee['name'] : $employeeId;
    }

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
                                Infolists\Components\TextEntry::make('vendor_complaint_id')
                                    ->label('Complaint ID')
                                    ->badge()
                                    ->color('danger')
                                    ->icon('heroicon-m-exclamation-triangle')
                                    ->visible(fn($state) => filled($state)),
                                Infolists\Components\TextEntry::make('employee_id')
                                    ->label('Employee')
                                    ->formatStateUsing(fn($state) => static::resolveEmployeeName($state)),
                                Infolists\Components\TextEntry::make('section'),
                                Infolists\Components\TextEntry::make('complaint_type')
                                    ->label('Category'),
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Raised At')
                                    ->dateTime('d-M-Y h:i A')
                                    ->timezone('Asia/Kolkata'),
                                Infolists\Components\TextEntry::make('location_details')
                                    ->label('Location (Bldg/Floor/Room)')
                                    ->getStateUsing(
                                        fn(HelpdeskTicket $record): string =>
                                        ($record->location?->location ?? '-') . ' / ' .
                                        ($record->floor ?? '-') . ' / ' .
                                        ($record->room?->name ?? '-')
                                    )
                                    ->icon('heroicon-m-map-pin')
                                    ->color('primary')
                                    ->columnSpan(1),
                                Infolists\Components\TextEntry::make('description')
                                    ->label('Problem Description')
                                    ->columnSpan(2)
                                    ->prose()
                                    ->markdown()
                                    ->icon('heroicon-m-chat-bubble-bottom-center-text'),
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
                            ->placeholder('Unassigned'),
                        Infolists\Components\TextEntry::make('vendor_complaint_id')
                            ->label('Complaint ID')
                            ->badge()
                            ->color('danger')
                            ->icon('heroicon-m-exclamation-triangle')
                            ->visible(fn($state) => filled($state)),
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
                Tables\Columns\TextColumn::make('vendor_complaint_id')
                    ->label('Complaint ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Requested By')
                    ->formatStateUsing(fn($state) => static::resolveEmployeeName($state))
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
                    ->dateTime('d-M-Y h:i A')
                    ->timezone('Asia/Kolkata')
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
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->check() && strtolower(auth()->user()->role ?? '') !== 'chm';
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $role = strtolower(auth()->user()->role ?? '');

        // Admin and Superadmin can see all tickets. Others (like chm, programmer) only see their assigned tickets.
        if (!in_array($role, ['admin', 'superadmin'])) {
            $query->where('technician_id', auth()->id());
        }

        return $query;
    }
}
