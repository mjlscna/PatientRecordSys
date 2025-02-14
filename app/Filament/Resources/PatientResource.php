<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make()->schema([
                    Section::make('Patient Information')
                        ->columnSpanFull()
                        ->schema([
                            Grid::make(2)->schema([

                                FileUpload::make('image')
                                    ->image()
                                    ->label('Patient Image')
                                    ->columnSpan(1)
                                    ->directory('patients'),


                                Toggle::make('is_active')
                                    ->label('Is Active')
                                    ->columnSpan(1)
                                    ->inline(false)
                                    ->default(true),
                            ]),


                            Grid::make(3)->schema([
                                TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('middle_name')
                                    ->label('Middle Name')
                                    ->required()
                                    ->columnSpan(1),
                            ]),


                            Grid::make(3)->schema([

                                Select::make('civil_status')
                                    ->label('Civil Status')
                                    ->options([
                                        'Single' => 'Single',
                                        'Married' => 'Married',
                                        'Separated' => 'Separated',
                                        'Divorced' => 'Divorced',
                                        'Widowed' => 'Widowed'
                                    ])
                                    ->default('Single')
                                    ->required()
                                    ->columnSpan(1),

                                DatePicker::make('birthday')
                                    ->label('Date of Birth')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('contact_number')
                                    ->label('Contact Number')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        ]),

                    Section::make('Patient Address')
                        ->columnSpanFull()
                        ->schema([

                            Grid::make(3)->schema([
                                TextInput::make('street')
                                    ->label('Street')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('brgy')
                                    ->label('Baranggay')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('city')
                                    ->label('City/Municipality')
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('province')
                                    ->label('Province')
                                    ->required()
                                    ->columnSpan(1),
                            ]),
                        ]),

                    Section::make('Emergency Contact')
                        ->columnSpanFull()
                        ->schema([

                            Grid::make(3)->schema([
                                TextInput::make('ec_name')
                                    ->label('Full Name')
                                    ->required()
                                    ->columnSpan(2),

                                Select::make('ec_relation')
                                    ->label('Relationship')
                                    ->options([
                                        'Spouse' => 'Spouse',
                                        'Parent' => 'Parent',
                                        'Sibling' => 'Sibling',
                                        'Child' => 'Child',
                                        'Grandparent' => 'Grandparent',
                                        'Aunt' => 'Aunt',
                                        'Uncle' => 'Uncle',
                                        'Nephew' => 'Nephew',
                                        'Niece' => 'Niece'
                                    ])
                                    ->default('Parent')
                                    ->required(),

                                TextInput::make('ec_address')
                                    ->label('Full Address')
                                    ->required()
                                    ->columnSpan(2),

                                TextInput::make('ec_contact')
                                    ->label('Contact Number')
                                    ->required()
                                    ->columnSpan(1),


                            ]),
                        ])
                ])->columnSpanFull(),


            ]); // Defines a 3-column layout

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('civil_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_number')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Deleted At')
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    RestoreAction::make(),
                    ForceDeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
