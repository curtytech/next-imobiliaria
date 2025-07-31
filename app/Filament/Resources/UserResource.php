<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Filament\Facades\Filament;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informações do Usuário')->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255),
                    
                TextInput::make('descricao')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255),

                TextInput::make('creci')
                    ->label('Creci')
                    ->maxLength(15),

                TextInput::make('celular')
                    ->label('Celular')
                    ->maxLength(15),

                TextInput::make('email')
                    ->label('E-mail')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Select::make('role')
                    ->label('Papel')
                    ->options(function () {
                        $user = Filament::auth()->user();

                        if ($user->role === 'corretor') {
                            return ['corretor' => 'Corretor']; 
                        }

                        return [
                            'admin' => 'Administrador',
                            'corretor' => 'Corretor',
                        ];
                    })
                    ->default('corretor')
                    ->required(),

                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->required(fn(string $context): bool => $context === 'create')
                    ->maxLength(255),
            ])->columns(2),

            Section::make('Foto')->schema([
                FileUpload::make('foto')
                    ->label('Foto de Perfil')
                    ->image()
                    ->directory('perfil_photos')
                    ->maxFiles(1),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('role')
                    ->label('Papel')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'corretor' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin' => 'Administrador',
                        'corretor' => 'Corretor',
                        default => ucfirst($state),
                    }),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Papel')
                    ->options([
                        'admin' => 'Administrador',
                        'corretor' => 'Corretor',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Filament::auth()->user();

        if ($user->role === 'corretor') {
            return $query->where('id', $user->id);
        }

        return $query;
    }
}
