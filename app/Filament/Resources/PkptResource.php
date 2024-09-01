<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PkptResource\Pages;
use App\Models\Pkpt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

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
                })
                ->searchable(),
            Tables\Columns\TextColumn::make('tanggal_mulai')
                ->date('d M Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('tanggal_selesai')
                ->date('d M Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('biaya')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('inspektur.name')
                ->label('Penanggung Jawab')
                ->sortable(),
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
            Tables\Columns\TextColumn::make('creator.name')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('editor.name')
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
            'index' => Pages\ListPkpts::route('/'),
            'create' => Pages\CreatePkpt::route('/create'),
            'view' => Pages\ViewPkpt::route('/{record}'),
            'edit' => Pages\EditPkpt::route('/{record}/edit'),
        ];
    }
}
