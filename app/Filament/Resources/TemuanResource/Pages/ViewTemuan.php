<?php

namespace App\Filament\Resources\TemuanResource\Pages;

use App\Filament\Resources\TemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Hugomyb\FilamentMediaAction\Forms\Components\Actions\MediaAction;
use Illuminate\Support\Facades\Storage;

class ViewTemuan extends ViewRecord
{
    protected static string $resource = TemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Forms\Form $form): Forms\Form
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
                    ->hiddenLabel()
                    ->relationship('files')
                    ->schema([
                        Forms\Components\TextInput::make('url')->label('File')
                            ->suffixAction(
                                MediaAction::make('url')
                                    ->modalHeading('')
                                    ->button()
                                    ->icon('heroicon-o-eye')
                                    ->label('Lihat')
                                    ->media(fn(Forms\Get $get) => Storage::url($get('url')))
                            ),
                        Forms\Components\TextInput::make('keterangan'),
                    ])
                    ->columnSpanFull()
            ])->columns(2)
        ]);
    }
}
