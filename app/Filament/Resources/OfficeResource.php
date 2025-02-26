<?php

namespace App\Filament\Resources;

use App\Livewire;
use App\Filament\Resources\OfficeResource\Pages;
use App\Filament\Resources\OfficeResource\RelationManagers;
use App\Models\Office;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class OfficeResource extends Resource
{
    protected static ?string $model = Office::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Office*')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                        ->label('Office Name')
                                        ->maxLength(25)
                                        ->required(),
                                Forms\Components\Select::make('is_district')
                                        ->label('Office Of')
                                        ->options([true => 'District', false => 'Village'])
                                        ->required(),
                                Forms\Components\Select::make('district_id')
                                        ->required()
                                        ->relationship('district', 'name')
                                        ->label('District')
                                        ->searchable()
                                        ->required(),
                                Forms\Components\FileUpload::make('image')
                                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                                        ->disk('public')
                                        ->directory('offices')
                                        ->enableOpen()
                                        ->imageResizeMode('cover')
                                        ->imageResizeTargetWidth('1920')
                                        ->imageResizeTargetHeight('1080')
                                        ->imageEditor()
                                        ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Location*')
                            ->schema([
                                // Embed the Livewire MapPicker component
                                Forms\Components\Livewire::make(Livewire\MapPicker::class)
                                    ->label('Select Location on Map')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->grow()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_district')
                    ->label('Office Of')
                    ->formatStateUsing(fn ($state) => $state ? 'District' : 'Village')
                    ->sortable(),
                Tables\Columns\TextColumn::make('district.name')->label('District Name'),
                Tables\Columns\TextColumn::make('longitude'),
                Tables\Columns\TextColumn::make('latitude'),
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->after(function (Office $record)  {
                    static::handleDeleteImage($record->image);
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records)  {
                        foreach($records as $key => $value) {
                            static::handleDeleteImage($value->image);
                        }
                    }),
                ]),
            ]);
    }

    private static function handleDeleteImage($image)
    {
        if($image) {
            Storage::disk('public')->delete($image);
        }
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
            'index' => Pages\ListOffices::route('/'),
            // 'create' => Pages\CreateOffice::route('/create'),
            // 'edit' => Pages\EditOffice::route('/{record}/edit'),
        ];
    }
}
