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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

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
            Forms\Components\Section::make('PKPT')->schema([
                Forms\Components\Select::make('pkpt_id')
                    ->label('Nama Kegiatan')
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
                        SptStatus::Disetujui->value => SptStatus::Disetujui->value,
                        SptStatus::Ditolak->value => SptStatus::Ditolak->value,
                        SptStatus::Dibatalkan->value => SptStatus::Dibatalkan->value,
                        SptStatus::SedangProses->value => SptStatus::SedangProses->value,
                        SptStatus::Selesai->value => SptStatus::Selesai->value,
                    ])
                    ->required(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('pkpt.nama_kegiatan')
                ->label('Nama kegiatan')
                ->limit(30)
                ->wrap()
                ->sortable(),
            Tables\Columns\TextColumn::make('tim.nama_tim')
                ->label('Tim pengawasan')
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
                Tables\Filters\SelectFilter::make('pkpt')
                    ->label('Nama kegiatan')
                    ->relationship('pkpt', 'nama_kegiatan')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari tanggal')
                            ->default(Carbon::now()->startOfMonth())
                            ->hintIcon(
                                icon: 'heroicon-m-question-mark-circle',
                                tooltip: 'Dari tanggal pembuatan SPT'
                            ),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai tanggal')
                            ->default(Carbon::now()->endOfMonth())
                            ->hintIcon(
                                icon: 'heroicon-m-question-mark-circle',
                                tooltip: 'Sampai tanggal pembuatan SPT'
                            ),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->columns(2),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->searchable()
                    ->options([
                        SptStatus::Draft->value => SptStatus::Draft->value,
                        SptStatus::Disetujui->value => SptStatus::Disetujui->value,
                        SptStatus::Ditolak->value => SptStatus::Ditolak->value,
                        SptStatus::Dibatalkan->value => SptStatus::Dibatalkan->value,
                        SptStatus::SedangProses->value => SptStatus::SedangProses->value,
                        SptStatus::Selesai->value => SptStatus::Selesai->value,
                    ]),
                Tables\Filters\SelectFilter::make('tim')
                    ->label('Tim pengawasan')
                    ->relationship('tim', 'nama_tim')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(2)
            ->deferFilters()
            ->filtersApplyAction(
                fn(Action $action) => $action
                    ->button()
                    ->icon('heroicon-o-magnifying-glass')
                    ->label('Search'),
            )
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
