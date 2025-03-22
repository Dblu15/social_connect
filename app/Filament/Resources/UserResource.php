<?php

namespace App\Filament\Resources;

use App\Enums\RoleUser;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'User';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->minLength(2)
                                    ->required(),
                                Forms\Components\TextInput::make('password')
                                    ->dehydrated(fn($state) => filled($state))
                                    ->minLength(6)
                                    ->password()
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->unique()
                                    ->Regex('/^.+$/i')
                                    ->required(),
                                Forms\Components\FileUpload::make('avatar')
                                    ->preserveFilenames()
                                    ->imageEditor()
                            ])
                            ->columnSpan(1),

                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('role')
                                    ->options(RoleUser::class)
                                    ->required(),
                                Forms\Components\Toggle::make('is_verify'),
                                Forms\Components\MarkdownEditor::make('bio')
                            ])
                            ->columnSpan(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('bio')
                    ->toggleable(),
                ImageColumn::make('avatar'),
                IconColumn::make('is_verify')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
    public static function canEdit($record): bool
    {
        return $record->role !== 'admin';
    }

    public static function canDelete($record): bool
    {
        return $record->role !== 'admin';
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
