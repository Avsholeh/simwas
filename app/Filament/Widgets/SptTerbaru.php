<?php

namespace App\Filament\Widgets;

use App\Enums\SptStatus;
use App\Filament\Resources\SptResource;
use App\Models\Spt;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SptTerbaru extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('SPT Terbaru')
            ->query(SptResource::getEloquentQuery()->orderByDesc('created_at'))
            ->columns([
                Tables\Columns\TextColumn::make('pkpt.nama_kegiatan')
                    ->label('Nama kegiatan')
                    ->limit(30)
                    ->wrap(),
                Tables\Columns\TextColumn::make('pkpt.objek_pengawasan')
                    ->label('Objek pengawasan')
                    ->limit(30)
                    ->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn($record) => match ($record->status) {
                        SptStatus::Draft->value => Color::Gray,
                        SptStatus::Disetujui->value => Color::Green,
                        SptStatus::Ditolak->value => Color::Red,
                        SptStatus::Dibatalkan->value => Color::Gray,
                        SptStatus::SedangProses->value => Color::Yellow,
                        SptStatus::Selesai->value => Color::Green,
                        default => null,
                    }),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Dibuat')
                    ->description(fn(Spt $spt) => $spt->created_at->diffForHumans()),
            ])
            ->defaultPaginationPageOption(5)
            ->paginationPageOptions([5]);
    }
}
