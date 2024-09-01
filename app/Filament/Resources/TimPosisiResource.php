<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimPosisiResource\Pages;
use App\Filament\Resources\TimPosisiResource\RelationManagers;
use App\Models\TimPosisi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimPosisiResource extends Resource
{
    protected static ?string $model = TimPosisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Posisi';
    }

    public static function getNavigationLabel(): string
    {
        return 'Posisi';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Tim';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_posisi')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_posisi')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTimPosisis::route('/'),
            'create' => Pages\CreateTimPosisi::route('/create'),
            'view' => Pages\ViewTimPosisi::route('/{record}'),
            'edit' => Pages\EditTimPosisi::route('/{record}/edit'),
        ];
    }
}
