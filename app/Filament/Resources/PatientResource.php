<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                [
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options(
                        [
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                        ]
                    )
                    ->required(),
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\Select::make('owner_id')
                // The first argument of the relationship() method is the name of the function that defines the relationship in the model
                //(used by Filament to load the select options) .
                //The second argument is the column name to use from the related table.
                    ->relationship('owner', 'name')
                    ->searchable()
                    // preload() the first 50 owners into the searchable list (in case the list is long)
                    ->preload()
                    ->createOptionForm(
                        [
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                        // label() overrides the auto-generated label for each field
                            ->label('Email address')
                            // email() ensures that only valid email addresses can be input into the field.
                            // It also changes the keyboard layout on mobile devices.
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone number')
                            // tel() ensures that only valid phone numbers can be input into the field. It also changes the keyboard layout on mobile devices.
                            ->tel()
                            ->required(),
                        ]
                    )
                    ->required()
                ]
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(
                [
                   Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('date_of_birth')
                ->sortable(),
                Tables\Columns\TextColumn::make('owner.name')
                ->searchable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                ]
            )
            ->filters(
                [
                    Tables\Filters\SelectFilter::make('type')
                ->options(
                    [
                    'cat' => 'Cat',
                    'dog' => 'Dog',
                    'rabbit' => 'Rabbit',
                    ]
                ),
                //
                ]
            )
            ->actions(
                [
                Tables\Actions\EditAction::make(),
                ]
            )
            ->bulkActions(
                [
                Tables\Actions\BulkActionGroup::make(
                    [
                    Tables\Actions\DeleteBulkAction::make(),
                    ]
                ),
                ]
            );
    }

    public static function getRelations(): array
    {
        return [
        RelationManagers\TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
