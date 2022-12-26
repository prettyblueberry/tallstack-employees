<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
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
use App\Models\City;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('country_id')
                        ->label('Country')
                        ->required()
                        ->options(Country::all()->pluck('name', 'id')->toArray())
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                    Select::make('state_id')
                        ->label('State')
                        ->required()
                        ->options(function (callable $get){
                            return State::where('country_id', $get('country_id'))->pluck('name','id')->toArray();

                        })
                        ->reactive()
                        ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                    Select::make('city_id')
                        ->label('City')
                        ->required()
                        ->options(function (callable $get){
                            return City::where('state_id', $get('state_id'))->pluck('name','id')->toArray();
                        }),
                    Select::make('department_id')
                        ->required()
                        ->relationship('department', 'name'),
                    TextInput::make('first_name')
                        ->required()
                        ->string()
                        ->maxLength(255),
                    TextInput::make('last_name')
                        ->required()
                        ->string()
                        ->maxLength(255),
                    TextInput::make('address')
                        ->required()
                        ->string()
                        ->maxLength(255),
                    TextInput::make('zip_code')
                        ->required()
                        ->string()
                        ->maxLength(6),
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
