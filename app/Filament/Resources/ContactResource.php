<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = "heroicon-o-envelope";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("name")->label("Name")->required(),
            Forms\Components\TextInput::make("email")
                ->label("Email")
                ->required(),
            Forms\Components\TextInput::make("subject")->label("Subject"),
            Forms\Components\Textarea::make("message")
                ->label("Message")
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("email")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("subject")
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make("message")->limit(50),
                Tables\Columns\TextColumn::make("created_at")->dateTime(
                    "d M Y, H:i"
                ),
            ])
            ->filters([
                Tables\Filters\Filter::make("today")
                    ->label("Today")
                    ->query(
                        fn($query) => $query->whereDate(
                            "created_at",
                            now()->toDateString()
                        )
                    ),

                Tables\Filters\Filter::make("last_week")
                    ->label("Last Week")
                    ->query(
                        fn($query) => $query->whereBetween("created_at", [
                            now()->subDays(7),
                            now(),
                        ])
                    ),

                Tables\Filters\Filter::make("subject")
                    ->form([
                        Forms\Components\TextInput::make("subject")->label(
                            "Subject"
                        ),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data["subject"],
                            fn($query, $subject) => $query->where(
                                "subject",
                                "like",
                                "%" . $subject . "%"
                            )
                        );
                    }),

                Tables\Filters\Filter::make("email")
                    ->form([
                        Forms\Components\TextInput::make("email")->label(
                            "Email"
                        ),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when(
                            $data["email"],
                            fn($query, $email) => $query->where(
                                "email",
                                "like",
                                "%" . $email . "%"
                            )
                        );
                    }),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            // Add this line to order the results by 'created_at' in descending order
            ->orderBy('created_at', 'desc');
    }


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
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
            "index" => Pages\ListContacts::route("/"),
            // 'create' => Pages\CreateContact::route('/create'),
            // 'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
