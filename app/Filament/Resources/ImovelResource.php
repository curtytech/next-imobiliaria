<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImovelResource\Pages;
use App\Filament\Resources\ImovelResource\RelationManagers;
use App\Models\Imovel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;


class ImovelResource extends Resource
{
    protected static ?string $model = Imovel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Imóveis';

    protected static ?string $modelLabel = 'Imóvel';

    protected static ?string $pluralModelLabel = 'Imóveis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações Básicas')
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('descricao')
                            ->label('Descrição')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'h2',
                                'h3',
                                'h4',
                                'undo',
                                'redo',
                                'removeFormat'
                            ])
                            ->columnSpanFull(),

                        Select::make('tipo_id')
                            ->label('Tipo de Imóvel')
                            ->relationship('tipo', 'nome')
                            ->required(),

                        Select::make('status_id')
                            ->label('Status')
                            ->relationship('statusImovel', 'nome')
                            ->required()
                            ->default(1),

                        Select::make('status_id')
                            ->label('Corretor Responsável')
                            ->relationship('statusImovel', 'nome')
                            ->required()
                            ->default(1),

                        Toggle::make('destaque')
                            ->label('Destaque')
                            ->default(false),
                    ])->columns(2),

                Section::make('Financeiro')
                    ->schema([
                        TextInput::make('iptu')
                            ->label('Preço de IPTU')
                            ->numeric()
                            ->prefix('R$'),
                        TextInput::make('condominio')
                            ->label('Preço de Condomínio')
                            ->numeric()
                            ->prefix('R$'),
                        TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->prefix('R$')
                            ->required(),

                    ])->columns(2),

                Section::make('Características')
                    ->schema([
                        TextInput::make('area')
                            ->label('Área ')
                            ->suffix(' m²')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        TextInput::make('area_util')
                            ->label('Área útil')
                            ->suffix(' m²')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('terreno')
                            ->label('Terreno')
                            ->suffix(' m²')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('area_constr')
                            ->label('Área constr.')
                            ->suffix(' m²')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('quartos')
                            ->label('Quartos')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('banheiros')
                            ->label('Banheiros')
                            ->numeric()
                            ->minValue(0),

                        TextInput::make('vagas_garagem')
                            ->label('Vagas de Garagem')
                            ->numeric()
                            ->minValue(0),
                    ])->columns(2),

                Section::make('Endereço')
                    ->schema([
                        TextInput::make('endereco')
                            ->label('Endereço')
                            ->required(),

                        TextInput::make('bairro')
                            ->label('Bairro')
                            ->required(),

                        TextInput::make('cidade')
                            ->label('Cidade')
                            ->required(),

                        TextInput::make('estado')
                            ->label('Estado')
                            ->length(2)
                            ->required(),

                        TextInput::make('cep')
                            ->label('CEP')
                            ->length(8)
                            ->numeric()
                            ->required(),

                        TextInput::make('localizacao_maps')
                            ->label('Localização Google Maps')
                            ->url()
                            ->required(),

                    ])->columns(2),

                Section::make('Características Extras')
                    ->schema([
                        KeyValue::make('caracteristicas')
                            ->label('Características Extras')
                            ->keyLabel('Característica')
                            ->valueLabel('Valor'),
                    ]),

                Section::make('Fotos')
                    ->schema([
                        FileUpload::make('fotos')
                            ->label('Fotos do Imóvel')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->directory('imoveis')
                            ->maxFiles(10),
                    ]),

                Section::make('Vídeos do YouTube')
                    ->schema([
                        Repeater::make('videos')
                            ->label('Links de Vídeos')
                            ->schema([
                                TextInput::make('url')
                                    ->label('URL do Vídeo')
                                    ->placeholder('https://www.youtube.com/watch?v=VIDEO_ID')
                                    ->url()
                                    ->required()
                                    ->helperText('Cole aqui o link completo do vídeo do YouTube')
                                    ->rules(['regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)[a-zA-Z0-9_-]+/'])
                                    ->validationMessages([
                                        'regex' => 'Por favor, insira um link válido do YouTube.',
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Adicionar Vídeo')
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => $state['url'] ?? null)
                            ->maxItems(5)
                            ->helperText('Adicione até 5 links de vídeos do YouTube para mostrar o imóvel'),
                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipo.nome')
                    ->label('Tipo')
                    ->sortable(),

                TextColumn::make('preco')
                    ->label('Preço')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('area')
                    ->label('Área')
                    ->suffix(' m²')
                    ->sortable(),

                TextColumn::make('cidade')
                    ->label('Cidade')
                    ->searchable(),

                TextColumn::make('statusImovel.nome')
                    ->label('Status')
                    ->badge()
                    ->color(fn($record) => match (strtolower($record->statusImovel->nome ?? '')) {
                        'disponivel' => 'success',
                        'vendido' => 'danger',
                        'alugado' => 'warning',
                        default => 'gray',
                    }),

                ToggleColumn::make('destaque')
                    ->label('Destaque'),

                // TextColumn::make('videos')
                //     ->label('Vídeos')
                //     ->formatStateUsing(fn($state) => $state ? count($state) . ' vídeo(s)' : 'Nenhum')
                //     ->badge()
                //     ->color(fn($state) => $state && count($state) > 0 ? 'success' : 'gray'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tipo')
                    ->label('Tipo')
                    ->options([
                        'casa' => 'Casa',
                        'apartamento' => 'Apartamento',
                        'terreno' => 'Terreno',
                        'comercial' => 'Comercial',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'disponivel' => 'Disponível',
                        'vendido' => 'Vendido',
                        'alugado' => 'Alugado',
                    ]),

                TernaryFilter::make('destaque')
                    ->label('Destaque'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListImovels::route('/'),
            'create' => Pages\CreateImovel::route('/create'),
            'edit' => Pages\EditImovel::route('/{record}/edit'),
        ];
    }
}
