<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimResource\Pages;
use App\Models\Tim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TimResource extends Resource
{
    protected static ?string $model = Tim::class;

    protected static ?string $navigationIcon = 'heroicon-m-squares-2x2';

    protected static ?string $slug = 'tim';

    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen Tim';
    }

    public static function getNavigationSort(): ?int
    {
        return 1;
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::formSchema());
    }

    public static function formSchema(): array
    {
        return [
            Forms\Components\Section::make()->schema([
                Forms\Components\TextInput::make('nama_tim')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('aktif')
                    ->label('Status Aktif')
                    ->searchable()
                    ->required()
                    ->default(1)
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make()->schema([
                Forms\Components\Repeater::make('timAnggota')
                    ->label('Anggota Tim')
                    ->relationship()
                    ->defaultItems(0)
                    ->schema([
                        Forms\Components\Select::make('anggota_id')
                            ->placeholder('Pilih Anggota')
                            ->hiddenLabel()
                            ->required()
                            ->relationship('anggota.user', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('posisi_id')
                            ->placeholder('Pilih Posisi')
                            ->hiddenLabel()
                            ->relationship('posisi', 'nama_posisi')
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
            ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('no')
                ->rowIndex(),
            Tables\Columns\TextColumn::make('nama_tim')
                ->limit(30)
                ->searchable(),
            Tables\Columns\TextColumn::make('deskripsi')
                ->limit(30)
                ->searchable(),
            Tables\Columns\TextColumn::make('anggota.user.name')
                ->label('Anggota')
                ->listWithLineBreaks(),
            Tables\Columns\TextColumn::make('statusAktif')
                ->color(fn(Tim $record) => $record->aktif ? 'success' : 'danger')
                ->badge()
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTims::route('/'),
            'create' => Pages\CreateTim::route('/create'),
            'view' => Pages\ViewTim::route('/{record}'),
            'edit' => Pages\EditTim::route('/{record}/edit'),
        ];
    }
}
