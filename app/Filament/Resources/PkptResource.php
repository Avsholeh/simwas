<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PkptResource\Pages;
use App\Models\Pkpt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PkptResource extends Resource
{
    protected static ?string $model = Pkpt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'pkpt';

    public static function getNavigationGroup(): ?string
    {
        return 'Perencanaan';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getModelLabel(): string
    {
        return 'Program Kerja Pengawasan Tahunan';
    }

    public static function getNavigationLabel(): string
    {
        return 'PKPT';
    }

    public static function form(Form $form): Form
    {
        $disableToolbarButtonsList = ['blockquote', 'attachFiles', 'blockquote', 'h2', 'h3', 'strike', 'codeBlock'];

        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('nama_kegiatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('objek_pengawasan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('keterangan_pengawasan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tingkat_risiko')
                    ->options([
                        'Tinggi' => 'Tinggi',
                        'Sedang' => 'Sedang',
                        'Rendah' => 'Rendah',
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\RichEditor::make('tujuan')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('sasaran')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('jumlah_hari')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('masa_periksa')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tanggal_mulai')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_selesai'),
                Forms\Components\TextInput::make('biaya')
                    ->prefix('Rp')
                    ->required()
                    ->columnSpanFull()
                    ->numeric(),
                Forms\Components\RichEditor::make('rencana_penyelesaian')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unit_pelaksana')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('sarana_penunjang')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('tahun_pelaksanaan')
                    ->searchable()
                    ->options(collect(range(date('Y') + 10, date('Y') - 10))->mapWithKeys(fn($year) => [$year => $year]))
                    ->required(),
                Forms\Components\Select::make('inspektur_id')
                    ->relationship('inspektur', 'name', modifyQueryUsing: fn($query) => $query->where('is_developer', 0))
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('dasar_surat')
                    ->columnSpanFull()
                    ->maxLength(255),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama_kegiatan')
                ->tooltip(fn(Pkpt $record) => $record->nama_kegiatan)
                ->limit(30)
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('objek_pengawasan')
                ->tooltip(fn(Pkpt $record) => $record->objek_pengawasan)
                ->limit(30)
                ->wrap()
                ->searchable(),
            Tables\Columns\TextColumn::make('tingkat_risiko')
                ->badge()
                ->color(fn($record) => match ($record->tingkat_risiko) {
                    'Tinggi' => Color::Red,
                    'Sedang' => Color::Yellow,
                    'Rendah' => Color::Green,
                    default => null,
                })
                ->searchable(),
            Tables\Columns\TextColumn::make('biaya')
                ->prefix('Rp ')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('inspektur.name')
                ->label('Penanggung jawab')
                ->wrap()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat pada')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Diperbarui pada')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('deleted_at')
                ->label('Dihapus pada')
                ->dateTime()
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
        ])
            ->filters(static::getFilters(), layout: FiltersLayout::AboveContent)
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

    private static function getFilters(): array
    {
        return [
            Tables\Filters\Filter::make('created_at')
                ->form([
                    Forms\Components\DatePicker::make('created_from')->label('Dari tanggal')
                        ->live()
                        ->suffixAction(function (Forms\Get $get) {
                            if (!empty($get('created_from'))) {
                                return Forms\Components\Actions\Action::make('clear')
                                    ->icon('heroicon-c-x-circle')
                                    ->action(function (Forms\Set $set) {
                                        $set('created_from', null);
                                    });
                            }
                        })
                        ->hintIcon(
                            icon: 'heroicon-m-question-mark-circle',
                            tooltip: 'Dari tanggal pembuatan PKPT'
                        ),
                    Forms\Components\DatePicker::make('created_until')->label('Sampai tanggal')
                        ->live()
                        ->suffixAction(function (Forms\Get $get) {
                            if (!empty($get('created_until'))) {
                                return Forms\Components\Actions\Action::make('clear')
                                    ->icon('heroicon-c-x-circle')
                                    ->action(function (Forms\Set $set) {
                                        $set('created_until', null);
                                    });
                            }
                        })
                        ->hintIcon(
                            icon: 'heroicon-m-question-mark-circle',
                            tooltip: 'Sampai tanggal pembuatan PKPT'
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
            Tables\Filters\SelectFilter::make('tingkat_risiko')
                ->searchable()
                ->options([
                    'Rendah' => 'Rendah',
                    'Sedang' => 'Sedang',
                    'Tinggi' => 'Tinggi',
                ]),
            Tables\Filters\SelectFilter::make('inspektur')
                ->relationship('inspektur', 'name')
                ->searchable()
                ->preload(),
            Tables\Filters\SelectFilter::make('tahun_pelaksanaan')
                ->searchable()
                ->preload()
                ->options(Pkpt::select('tahun_pelaksanaan')->distinct()->get()->mapWithKeys(fn($item) => [$item->tahun_pelaksanaan => $item->tahun_pelaksanaan])),
        ];
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
            'index' => Pages\ListPkpts::route('/'),
            'create' => Pages\CreatePkpt::route('/create'),
            'view' => Pages\ViewPkpt::route('/{record}'),
            'edit' => Pages\EditPkpt::route('/{record}/edit'),
        ];
    }
}
