<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaktuPresensiResource\Pages;
use App\Filament\Resources\WaktuPresensiResource\RelationManagers;
use App\Models\WaktuPresensi;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaktuPresensiResource extends Resource
{
    protected static ?string $model = WaktuPresensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'Waktu Presensi';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $breadcrumb = 'Waktu Presensi';

    protected static ?string $slug = 'waktu-presensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('hari')
                    ->options([
                        'senin' => 'Senin',
                        'selasa' => 'Selasa',
                        'rabu' => 'Rabu',
                        'kamis' => 'Kamis',
                        'jumat' => 'Jum`at'
                    ])
                    ->required(),
                Forms\Components\Select::make('sesi_id')
                    ->relationship('sesi', 'sesi.nama')
                    ->required(),
                Forms\Components\TimePicker::make('waktu_mulai')->required(),
                Forms\Components\TimePicker::make('waktu_selesai')->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Non Aktif'
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hari'),
                Tables\Columns\TextColumn::make('sesi.nama'),
                Tables\Columns\TextColumn::make('waktu_mulai'),
                Tables\Columns\TextColumn::make('waktu_selesai'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListWaktuPresensis::route('/'),
            'create' => Pages\CreateWaktuPresensi::route('/create'),
            'edit' => Pages\EditWaktuPresensi::route('/{record}/edit'),
        ];
    }
}
