<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShareResource\Pages;
use App\Filament\Resources\ShareResource\RelationManagers;
use App\Models\Share;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShareResource extends Resource
{
    protected static ?string $model = Share::class;

    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Social';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('post_id')
                            ->relationship('post', 'content')
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn($record) => \Illuminate\Support\Str::limit($record->content, 50)),
                        Forms\Components\Radio::make('type')
                            ->options([
                                'profile' => 'Profile',
                                'group' => 'Group',
                                'page' => 'Page',
                            ])
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('post.content')
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListShares::route('/'),
            'create' => Pages\CreateShare::route('/create'),
            'edit' => Pages\EditShare::route('/{record}/edit'),
        ];
    }
}
