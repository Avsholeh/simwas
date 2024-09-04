<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemuanResource\Pages;
use App\Models\Temuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class TemuanResource extends Resource
{
    protected static ?string $model = Temuan::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-magnifying-glass';

    protected static ?string $slug = 'temuan';

    public static function getNavigationGroup(): ?string
    {
        return 'Pelaksanaan';
    }

    public static function getNavigationSort(): ?int
    {
        return 3;
    }

    public static function getModelLabel(): string
    {
        return 'Temuan';
    }

    public static function getNavigationLabel(): string
    {
        return 'Temuan';
    }

    public static function form(Form $form): Form
    {
        $disableToolbarButtonsList = ['blockquote', 'attachFiles', 'blockquote', 'h2', 'h3', 'strike', 'codeBlock'];

        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\Select::make('lha_id')
                    ->label('Nomor LHA')
                    ->relationship('lha', 'nomor')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('tahun_pelaksanaan')
                    ->default(date('Y'))
                    ->options(collect(range(date('Y') + 10, date('Y') - 10))->mapWithKeys(fn($year) => [$year => $year]))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('objek_pengawasan')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kode')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('kondisi')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('kriteria')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('akibat')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rekomendasi_kode')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('rekomendasi_temuan')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('files')
                    ->relationship('files')
                    ->schema([
                        Forms\Components\FileUpload::make('url')
                            ->hiddenLabel()
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                                return (string) str()->ulid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                            })
                            ->fetchFileInformation(false)
                            ->directory("Temuan/" . now()->year)
                            ->downloadable(),
                        Forms\Components\TextInput::make('keterangan'),
                    ])
                    ->columnSpanFull()
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('no')
                ->rowIndex(),
            Tables\Columns\TextColumn::make('lha.nomor')
                ->label('Nomor LHA')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('tahun_pelaksanaan')
                ->sortable(),
            Tables\Columns\TextColumn::make('objek_pengawasan')
                ->limit(20)
                ->tooltip(fn($record) => strip_tags($record->objek_pengawasan))
                ->searchable(),
            Tables\Columns\TextColumn::make('judul')
                ->limit(20)
                ->tooltip(fn($record) => strip_tags($record->judul))
                ->searchable(),
            Tables\Columns\IconColumn::make('files')
                ->icon(fn(mixed $state) => !empty($state) ? 'heroicon-o-check-circle' : 'heroicon-s-x-circle')
                ->color(fn(mixed $state) => !empty($state) ? Color::Green : Color::Red),
            ...\App\Filament\DefaultTableColumn::make()
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemuans::route('/'),
            'create' => Pages\CreateTemuan::route('/create'),
            'view' => Pages\ViewTemuan::route('/{record}'),
            'edit' => Pages\EditTemuan::route('/{record}/edit'),
        ];
    }
}
