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
use Illuminate\Database\Eloquent\Builder;

class SptResource extends Resource
{
    protected static ?string $model = Spt::class;

    protected static ?string $navigationIcon = 'heroicon-m-document-text';

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

                Forms\Components\Select::make('status')
                    ->searchable()
                    ->options([
                        SptStatus::Draft->value => SptStatus::Draft->value,
                        SptStatus::SedangProses->value => SptStatus::SedangProses->value,
                        SptStatus::Dibatalkan->value => SptStatus::Dibatalkan->value,
                        SptStatus::Ditolak->value => SptStatus::Ditolak->value,
                        SptStatus::Disetujui->value => SptStatus::Disetujui->value,
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
            ...\App\Filament\DefaultTableColumn::make(),
        ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('Dari tanggal')
                            ->live()
                            ->suffixAction(
                                function (Forms\Get $get) {
                                    if (!empty($get('created_from'))) {
                                        return Forms\Components\Actions\Action::make('clear')
                                            ->icon('heroicon-c-x-circle')
                                            ->action(function (Forms\Set $set) {
                                                $set('created_from', null);
                                            });
                                    }
                                }
                            )
                            ->hintIcon(
                                icon: 'heroicon-m-question-mark-circle',
                                tooltip: 'Dari tanggal pembuatan SPT'
                            ),
                        Forms\Components\DatePicker::make('created_until')->label('Sampai tanggal')
                            ->live()
                            ->suffixAction(
                                function (Forms\Get $get) {
                                    if (!empty($get('created_until'))) {
                                        return Forms\Components\Actions\Action::make('clear')
                                            ->icon('heroicon-c-x-circle')
                                            ->action(function (Forms\Set $set) {
                                                $set('created_until', null);
                                            });
                                    }
                                }
                            )
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
                Tables\Filters\SelectFilter::make('pkpt')
                    ->label('Nama kegiatan')
                    ->relationship('pkpt', 'nama_kegiatan')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->searchable()
                    ->options([
                        SptStatus::Draft->value => SptStatus::Draft->value,
                        SptStatus::SedangProses->value => SptStatus::SedangProses->value,
                        SptStatus::Dibatalkan->value => SptStatus::Dibatalkan->value,
                        SptStatus::Ditolak->value => SptStatus::Ditolak->value,
                        SptStatus::Disetujui->value => SptStatus::Disetujui->value,
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
                fn(Tables\Actions\Action $action) => $action
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
