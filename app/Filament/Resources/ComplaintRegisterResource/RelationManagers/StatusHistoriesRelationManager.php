<?php

namespace App\Filament\Resources\ComplaintRegisterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusHistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
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
                    }),
                Tables\Columns\TextColumn::make('ticket.vendor_complaint_id')
                    ->label('Complaint ID')
                    ->badge()
                    ->color('danger')
                    ->icon('heroicon-m-exclamation-triangle')
                    ->visible(fn (\Filament\Resources\RelationManagers\RelationManager $livewire) => filled($livewire->getOwnerRecord()->vendor_complaint_id)),
                Tables\Columns\TextColumn::make('remarks')
                    ->wrap(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Updated By')
                    ->placeholder('Unassigned'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('d-M-Y h:i A')
                    ->timezone('Asia/Kolkata')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Disable manual creation
            ])
            ->actions([
                // Read-only history
            ])
            ->bulkActions([
                //
            ]);
    }
}
