<?php

namespace App\Filament;

use Filament\Tables;

class DefaultTableColumn
{
    public static function make()
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat')
                ->since()
                ->tooltip(fn($record) => $record->created_at->format('d M Y H:i:s'))
                ->description(fn($record) => $record->creator?->name)
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diperbarui')
                ->since()
                ->tooltip(fn($record) => $record->created_at->format('d M Y H:i:s'))
                ->sortable()
                ->description(fn($record) => $record->editor?->name)
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
