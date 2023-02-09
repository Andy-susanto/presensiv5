<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Filament\Resources\PresensiResource\RelationManagers;
use App\Models\Presensi;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Presensi';

    protected static ?string $breadcrumb = 'Presensi';

    protected static ?string $slug = 'presensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama_pegawai')
                    ->required(),
                Forms\Components\DateTimePicker::make('waktu'),
                Forms\Components\TextInput::make('foto_presensi')
                    ->required(),
                Forms\Components\TextInput::make('keterangan')
                    ->required(),
                Forms\Components\TextInput::make('ip_address')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 3,
                'xl' => 3
            ])
            ->columns(
                [
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\ImageColumn::make('foto_presensi')->size(200),
                        Tables\Columns\TextColumn::make('pegawai.nama_pegawai')->searchable(),
                        Tables\Columns\BadgeColumn::make('waktu')
                            ->colors(['success'])
                            ->dateTime(),
                        Tables\Columns\TextColumn::make('keterangan'),
                    ])
                ]
            )
            ->filters(
                [
                    Tables\Filters\SelectFilter::make('pegawai_id')->relationship('pegawai', 'nama_pegawai')->multiple()->label('Nama Pegawai'),
                    Tables\Filters\Filter::make('waktu')->form([
                        Forms\Components\DatePicker::make('waktu_presensi')->closeOnDateSelection()
                    ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['waktu_presensi'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('waktu', $date)
                                );
                        })
                ],
                layout: Tables\Filters\Layout::AboveContent,
            )
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
}
