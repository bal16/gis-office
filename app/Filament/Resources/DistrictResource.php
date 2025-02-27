<?php

namespace App\Filament\Resources;

use App\Livewire;
use App\Filament\Resources\DistrictResource\Pages;
use App\Filament\Resources\DistrictResource\RelationManagers;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DistrictResource extends Resource
{
    protected static ?string $model = District::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('District Information')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('District Name')
                                ->maxLength(25)
                                ->required(),
                            ]),
                Forms\Components\Repeater::make('offices')
                    ->columnSpanFull()
                    ->relationship('offices')
                    // ->maxItems(1)
                    ->defaultItems(0)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                                ->label('Office Name')
                                ->maxLength(25)
                                ->required(),
                        Forms\Components\Select::make('is_district')
                                ->label('Office Of')
                                ->default(true)
                                ->options([true => 'District', false => 'Village'])
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
                        Forms\Components\TextInput::make('map_url')
                            ->url()
                            ->startsWith('https://www.google.com/maps/place/')
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                $current = explode('/', $state);
                                $arr = explode(',', $current[6]);
                                $long = explode('@',$arr[0])[1];
                                $lat = $arr[1];
                                $set('longitude', $long);
                                $set('latitude', $lat);
                            })
                            ->hint('Url must be https://www.google.com/maps/place/...')
                            ->live(onBlur: true),
                        Forms\Components\TextInput::make('longitude')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('latitude')
                            ->numeric()
                            ->required(),
                    ]),
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
                Tables\Columns\TextColumn::make('Villages Count')
                    ->state(fn (District $record): string => $record->offices->where('is_district', '=', false)->count()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListDistricts::route('/'),
            // 'create' => Pages\CreateDistrict::route('/create'),
            // 'edit' => Pages\EditDistrict::route('/{record}/edit'),
        ];
    }
}
