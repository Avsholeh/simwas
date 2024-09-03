<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LhaResource\Pages;
use App\Models\Lha;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class LhaResource extends Resource
{
    protected static ?string $model = Lha::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'lha';

    public static function getNavigationGroup(): ?string
    {
        return 'Pelaksanaan';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function getModelLabel(): string
    {
        return 'Laporan Hasil Audit';
    }

    public static function getNavigationLabel(): string
    {
        return 'LHA';
    }

    public static function form(Form $form): Form
    {
        $disableToolbarButtonsList = ['blockquote', 'attachFiles', 'blockquote', 'h2', 'h3', 'strike', 'codeBlock'];

        return $form->schema([
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('nomor')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')
                    ->default(now())
                    ->required(),
                Forms\Components\RichEditor::make('deskripsi')
                    ->disableToolbarButtons($disableToolbarButtonsList)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file): string {
                        return (string) str()->ulid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                    })
                    ->directory("LHA/" . now()->year)
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
                Tables\Columns\TextColumn::make('nomor')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->nomor)
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->limit(20)
                    ->tooltip(fn($record) => $record->deskripsi ? strip_tags($record->deskripsi) : null)
                    ->html()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('file')
                    ->tooltip(fn($record) => empty($record->file) ? 'File belum ada atau tidak tersedia' : implode(', ', $record->file))
                    ->icon(fn(mixed $state) => !empty($state) ? 'heroicon-o-check-circle' : 'heroicon-s-x-circle')
                    ->color(fn(mixed $state) => !empty($state) ? Color::Green : Color::Red),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Dihapus pada')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_by')
                    ->label('Dibuat oleh')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_by')
                    ->label('Diperbarui oleh')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->label('Dihapus oleh')
                    ->numeric()
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
            'index' => Pages\ListLhas::route('/'),
            'create' => Pages\CreateLha::route('/create'),
            'view' => Pages\ViewLha::route('/{record}'),
            'edit' => Pages\EditLha::route('/{record}/edit'),
        ];
    }
}
