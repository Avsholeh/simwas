<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        Table::configureUsing(function (Table $table): void {
            $table
                ->filtersLayout(FiltersLayout::AboveContentCollapsible)
                ->defaultPaginationPageOption(10)
                ->paginationPageOptions([10, 25, 50, 100])
                ->deferLoading()
                ->searchDebounce(500)
                ->striped()
                ->defaultSort('id', 'desc');
        });

        Textarea::configureUsing(function (Textarea $ta) {
            $ta->autosize();
        });

        DatePicker::configureUsing(function (DatePicker $datePicker): void {
            $datePicker->native(false)->displayFormat('d M Y');
        });

        ViewAction::configureUsing(function (ViewAction $action) {
            $action->tooltip(__('filament-actions::view.single.label'))->hiddenLabel();
        });

        EditAction::configureUsing(function (EditAction $action) {
            $action->tooltip(__('filament-actions::edit.single.label'))->hiddenLabel();
        });

        DeleteAction::configureUsing(function (DeleteAction $action) {
            $action->tooltip(__('filament-actions::delete.single.label'))->hiddenLabel();
        });
    }
}
