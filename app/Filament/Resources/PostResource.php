<?php

namespace App\Filament\Resources;

use App\Enums\PostPrivacy;
use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;


class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Social';

    protected static int $globalSearchResultsLimit = 20;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name', 'content'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->user->name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            \Str::limit($record->content, 50),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    protected static ?string $globalSearchResultIcon = 'heroicon-o-hand-thumb-up';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->relationship('user', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Select::make('privacy')
                                    ->options(PostPrivacy::class)
                                    ->default('public'),
                                Forms\Components\FileUpload::make('image')
                                    ->preserveFilenames()
                                    ->directory('posts')
                                    ->imageEditor(),
                                Forms\Components\Toggle::make('status')
                                    ->inline(false),
                            ])->columns(2),
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\MarkdownEditor::make('content')
                                    ->required(),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('content')
                    ->limit(50)
                    ->searchable()
                ,
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('privacy'),
                Tables\Columns\TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn ($state) => $state ? 'Published' : 'Draft')
                    ->colors([
                        'success' => fn ($state) => $state === 1,
                        'gray' => fn ($state) => $state === 0,
                    ])
                    ->icons([
                        'heroicon-o-check-circle' => 1,
                        'heroicon-o-x-circle' => 0,
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
