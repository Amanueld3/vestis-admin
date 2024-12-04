<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Select::make('category')
                    ->label('Category')
                    ->options([
                        'Uniforms' => 'Uniforms',
                        'Visibility' => 'High Visibility Garments',
                        'Medical' => 'Medical Textiles/Equipments',
                        'Fashion' => 'Active, Fashion, Formal & Casual',
                    ])
                    ->required(),
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->label('Avatar')
                    ->rules('file', 'mimes:png,jpg,jpeg,gif,svg', 'max:5048')->required(),

                RichEditor::make('description')
                    ->label('Description')
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('avatar'),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('category')->sortable()->searchable(),
                TextColumn::make('description')->searchable()->html(),

            ])
            ->filters([
                Filter::make('category')
                    ->query(function (Builder $query, $value) {
                        $query->where('category', $value);
                    })
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
