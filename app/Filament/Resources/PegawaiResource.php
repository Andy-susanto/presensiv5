<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationLabel = 'Pegawai';

    protected static ?string $navigationGroup = 'Data Master';

    protected static ?string $breadcrumb = 'Pegawai';

    protected static ?string $slug = 'pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('nama_pegawai')
                    ->maxLength(65535)
                    ->required(),
                Forms\Components\Select::make('unit_kerja_id')
                    ->label('Unit Kerja')
                    ->relationship('unit_kerja', 'nama_unit_kerja')
                    ->required(),
                Forms\Components\Select::make('jabatan_id')
                    ->label('Jabatan')
                    ->relationship('jabatan', 'nama_jabatan')
                    ->required(),
                Forms\Components\TextInput::make('nip'),
                Forms\Components\TextInput::make('gelar_depan')
                    ->maxLength(100),
                Forms\Components\TextInput::make('gelar_belakang')
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_kerja.nama_unit_kerja'),
                Tables\Columns\TextColumn::make('jabatan.nama_jabatan'),
                Tables\Columns\TextColumn::make('nama_pegawai')->label('Nama Pegawai')->searchable(),
                Tables\Columns\TextColumn::make('nip')->label('nip')->copyable()->sortable(),
                Tables\Columns\TextColumn::make('nip'),
                Tables\Columns\TextColumn::make('gelar_depan'),
                Tables\Columns\TextColumn::make('gelar_belakang'),
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
                Tables\Actions\Action::make('Make User')
                    ->action(function (Pegawai $record) {
                        $record->makeUser();
                        Notification::make()
                            ->title('Berhasil Membuat User')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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

    public function isTableSearchable(): bool
    {
        return true;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}
