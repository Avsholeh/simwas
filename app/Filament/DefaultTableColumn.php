<?php

namespace App\Filament;

use Filament\Tables;

class DefaultTableColumn
{
    public static function make()
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat pada')
                ->since()
                ->tooltip(fn($record) => $record->created_at->format('d M Y H:i:s'))
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diperbarui pada')
                ->dateTime('d M Y H:i:s')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('deleted_at')
                ->label('Dihapus pada')
                ->dateTime('d M Y H:i:s')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('creator.name')
                ->label('Dibuat oleh')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('editor.name')
                ->label('Diperbarui oleh')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
