<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';



    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->options(fn () => \App\Models\User::query()->pluck('name', 'id'))
                    ->preload()
                    ->searchable()
                    ->required()
                    ->label(__('Select User')),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modelLabel('Usuario')
            ->pluralModelLabel('Usuarios')
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('pivot.progress')
                    ->label(__('Progress'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pivot.is_enrolled')
                    ->label(__('Is Enrolled'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make('Attach User')
                    ->icon('heroicon-s-user-plus')
                    ->label('Liberar acesso')
                    ->preloadRecordSelect()
            ])
            ->recordActions([

                DetachAction::make()
                    ->icon('heroicon-s-hand-thumb-down')
                    ->label('Remover acesso'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),

                ]),
            ]);
    }
}
