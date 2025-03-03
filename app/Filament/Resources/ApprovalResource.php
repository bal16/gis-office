<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ApprovalResource\Pages;
use App\Filament\Resources\ApprovalResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApprovalResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'Approval';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\Toggle::make('accepted_at')
                    ->label('Accepted')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->grow(),
                Tables\Columns\ToggleColumn::make('accepted_at')
                    ->label('Accepted')
                    ->onIcon('heroicon-m-check-circle')
                    ->offIcon('heroicon-m-x-circle')
                    ->afterStateUpdated(function(User $record, $state){
                        $result = $state ? now() : null;
                        $record->accepted_at = $result;
                        $record->save();

                        $state &&
                            Notification::make('success')
                                ->body("$record->name has been Approved")
                                ->success()
                                ->send();
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('pending')
                    ->query(fn(Builder $query): Builder => $query->whereNull('accepted_at'))
                    ->label('Pending')
                    ->default(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListApprovals::route('/'),
            // 'create' => Pages\CreateAdmin::route('/create'),
            // 'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
