<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KkaResource\Pages;
use App\Models\Kka;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class KkaResource extends Resource
{
    protected static ?string $model = Kka::class;

    protected static ?string $navigationIcon = 'heroicon-m-document-magnifying-glass';

    protected static ?string $slug = 'kka';

    public static function getNavigationGroup(): ?string
    {
        return 'Pelaksanaan';
    }

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function getModelLabel(): string
    {
        return 'Kertas Kerja Audit';
    }

    public static function getNavigationLabel(): string
    {
        return 'KKA';
    }

    public static function form(Form $form): Form
    {
        $disableToolbarButtonsList = ['blockquote', 'attachFiles', 'blockquote', 'h2', 'h3', 'strike', 'codeBlock'];

        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('keterangan')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->acceptedFileTypes(['application/pdf'])
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str()->ulid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    })
                    ->fetchFileInformation(false)
                    ->directory("KKA/" . now()->year)
                    ->multiple()
                    ->downloadable()
                    ->columnSpanFull(),
            ])->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->nama)
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->limit(20)
                    ->tooltip(fn($record) => strip_tags($record->keterangan))
                    ->html()
                    ->sortable(),
                Tables\Columns\IconColumn::make('file')
                    ->tooltip(fn($record) => empty($record->file) ? 'File belum ada atau tidak tersedia' : implode(', ', $record->file))
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
            'index' => Pages\ListKkas::route('/'),
            'create' => Pages\CreateKka::route('/create'),
            'view' => Pages\ViewKka::route('/{record}'),
            'edit' => Pages\EditKka::route('/{record}/edit'),
        ];
    }
}
