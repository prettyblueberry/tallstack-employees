<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('country_id')
                        ->required()
                        ->relationship('country', 'name'),
                    Select::make('state_id')
                        ->required()
                        ->relationship('state', 'name'),
                    Select::make('city_id')
                        ->required()
                        ->relationship('city', 'name'),
                    Select::make('department_id')
                        ->required()
                        ->relationship('department', 'name'),
                    TextInput::make('first_name')
                        ->required(),
                    TextInput::make('last_name')
                        ->required(),
                    TextInput::make('address')
                        ->required(),
                    TextInput::make('zip_code')
                        ->required(),
                    DatePicker::make('birth_date'),
                    DatePicker::make('date_hired')
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('department.name')
                    ->sortable()
                    ->searchable(),
                // TextColumn::make('country.name')
                //     ->label('State')
                //     ->sortable()
                //     ->searchable(),
                // TextColumn::make('state.name')
                //     ->label('State')
                //     ->sortable()
                //     ->searchable(),
                // TextColumn::make('city.name')
                //     ->label('State')
                //     ->sortable()
                //     ->searchable(),
                // TextColumn::make('state.country.name')
                //     ->label('Country')
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('department')
                    ->relationship('department', 'name'),
                SelectFilter::make('country')
                    ->relationship('country', 'name'),
                SelectFilter::make('state')
                    ->relationship('state', 'name'),
                SelectFilter::make('city')
                    ->relationship('city', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
