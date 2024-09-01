<?php

namespace App\Filament\Resources;

use App\Enums\SptStatus;
use App\Filament\Resources\SptResource\Pages;
use App\Models\Spt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class SptResource extends Resource
{
    protected static ?string $model = Spt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'spt';

    public static function getNavigationGroup(): ?string
    {
        return 'Perencanaan';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getModelLabel(): string
    {
        return 'Surat Perintah Tugas';
    }

    public static function getNavigationLabel(): string
    {
        return 'SPT';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->label('PKPT')->schema([
                Forms\Components\Select::make('pkpt_id')
                    ->label('PKPT')
                    ->searchable()
                    ->preload()
                    ->relationship('pkpt', 'nama_kegiatan')
                    ->required(),
            ]),

            Forms\Components\Section::make()->label('PKPT')->schema([
                Forms\Components\Select::make('tim_id')
                    ->label('Tim Pengawasan')
                    ->searchable()
                    ->preload()
                    ->relationship('tim', 'nama_tim')
                    ->createOptionForm(TimResource::formSchema())
                    ->editOptionForm(TimResource::formSchema()),
            ]),

            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('no_spt')
                    ->label('Nomor SPT')
                    ->maxLength(255)
                    ->columnSpanFull(),
                    
                Forms\Components\DatePicker::make('tanggal_mulai'),
                Forms\Components\DatePicker::make('tanggal_selesai'),

                Forms\Components\TextInput::make('verif_irban')
                    ->label('Verifikasi Irban'),

                Forms\Components\TextInput::make('verif_inspektur')
                    ->label('Verifikasi Inspektur'),

                Forms\Components\Select::make('status')
                    ->searchable()
                    ->options([
                        SptStatus::Draft->value => SptStatus::Draft->value,
                        SptStatus::VerifikasiIrban->value => SptStatus::VerifikasiIrban->value,
                        SptStatus::VerifikasiInspektur->value => SptStatus::VerifikasiInspektur->value,
                        SptStatus::Disetujui->value => SptStatus::Disetujui->value,
                        SptStatus::Ditolak->value => SptStatus::Ditolak->value,
                        SptStatus::Dibatalkan->value => SptStatus::Dibatalkan->value,
                        SptStatus::SedangBerjalan->value => SptStatus::SedangBerjalan->value,
                        SptStatus::Selesai->value => SptStatus::Selesai->value,
                        SptStatus::Diperpanjang->value => SptStatus::Diperpanjang->value,
                        SptStatus::Diperiksa->value => SptStatus::Diperiksa->value,
                        SptStatus::Dikembalikan->value => SptStatus::Dikembalikan->value,
                        SptStatus::Diketahui->value => SptStatus::Diketahui->value,
                    ])
                    ->required(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('pkpt.nama_kegiatan')
                ->label('PKPT (Kegiatan)')
                ->wrap()
                ->sortable(),
            Tables\Columns\TextColumn::make('tim.nama_tim')
                ->label('Tim Pengawasan')
                ->sortable(),
            Tables\Columns\TextColumn::make('no_spt')
                ->label('Nomor SPT')
                ->searchable(),
            Tables\Columns\TextColumn::make('tanggal_mulai')
                ->date('d M Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('tanggal_selesai')
                ->date('d M Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('verif_irban')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('verif_inspektur')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn($record) => match ($record->status) {
                    SptStatus::Draft->value => Color::Gray,
                    SptStatus::VerifikasiIrban->value => Color::Blue,
                    SptStatus::VerifikasiInspektur->value => Color::Blue,
                    SptStatus::Disetujui->value => Color::Green,
                    SptStatus::Ditolak->value => Color::Red,
                    SptStatus::Dibatalkan->value => Color::Gray,
                    SptStatus::SedangBerjalan->value => Color::Yellow,
                    SptStatus::Selesai->value => Color::Green,
                    SptStatus::Diperpanjang->value => Color::Yellow,
                    SptStatus::Diperiksa->value => Color::Blue,
                    SptStatus::Dikembalikan->value => Color::Red,
                    SptStatus::Diketahui->value => Color::Green,
                })
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('deleted_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_by')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_by')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('deleted_by')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSpts::route('/'),
            'create' => Pages\CreateSpt::route('/create'),
            'view' => Pages\ViewSpt::route('/{record}'),
            'edit' => Pages\EditSpt::route('/{record}/edit'),
        ];
    }
}
