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
use Filament\Facades\Filament;


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
                            ->relationship('tipoImovel', 'nome')
                            ->required(),

                        Select::make('situacao')
                            ->label('Situação')
                            ->options([
                                'vende-se' => 'Vende-se',
                                'aluga-se' => 'Aluga-se',
                            ])
                            ->required(),

                        Select::make('status_id')
                            ->label('Status')
                            ->relationship('statusImovel', 'nome')
                            ->required()
                            ->default(1),

                        Select::make('user_id')
                            ->label('Corretor Responsável')
                            ->relationship('corretor', 'name')
                            ->required(),

                        Toggle::make('destaque')
                            ->label('Destaque')
                            ->default(false),
                    ])->columns(2),

                Section::make('Financeiro')
                    ->schema([
                        TextInput::make('preco')
                            ->label('Preço')
                            ->numeric()
                            ->prefix('R$')
                            ->required(),
                        TextInput::make('preco_iptu')
                            ->label('Preço de IPTU')
                            ->numeric()
                            ->prefix('R$'),
                        TextInput::make('preco_condominio')
                            ->label('Preço de Condomínio')
                            ->numeric()
                            ->prefix('R$'),


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
                            ->required(),

                        // Select::make('estado')
                        //     ->label('Estado')
                        //     ->options([
                        //         'AC' => 'Acre',
                        //         'AL' => 'Alagoas',
                        //         'AP' => 'Amapá',
                        //         'AM' => 'Amazonas',
                        //         'BA' => 'Bahia',
                        //         'CE' => 'Ceará',
                        //         'DF' => 'Distrito Federal',
                        //         'ES' => 'Espírito Santo',
                        //         'GO' => 'Goiás',
                        //         'MA' => 'Maranhão',
                        //         'MT' => 'Mato Grosso',
                        //         'MS' => 'Mato Grosso do Sul',
                        //         'MG' => 'Minas Gerais',
                        //         'PA' => 'Pará',
                        //         'PB' => 'Paraíba',
                        //         'PR' => 'Paraná',
                        //         'PE' => 'Pernambuco',
                        //         'PI' => 'Piauí',
                        //         'RJ' => 'Rio de Janeiro',
                        //         'RN' => 'Rio Grande do Norte',
                        //         'RS' => 'Rio Grande do Sul',
                        //         'RO' => 'Rondônia',
                        //         'RR' => 'Roraima',
                        //         'SC' => 'Santa Catarina',
                        //         'SP' => 'São Paulo',
                        //         'SE' => 'Sergipe',
                        //         'TO' => 'Tocantins',
                        //     ])
                        //     ->required(),

                        Select::make('pais')
                            ->label('País')
                            ->options([
                                'Brasil' => 'Brasil',
                                'Estados Unidos' => 'Estados Unidos',
                                'Argentina' => 'Argentina',
                                'Chile' => 'Chile',
                                'Alemanha' => 'Alemanha',
                                'Áustria' => 'Áustria',
                                'Bulgária' => 'Bulgária',
                                'Dinamarca' => 'Dinamarca',
                                'Espanha' => 'Espanha',
                                'França' => 'França',
                                'Grécia' => 'Grécia',
                                'Irlanda' => 'Irlanda',
                                'Islândia' => 'Islândia',
                                'Itália' => 'Itália',
                                'Letônia' => 'Letônia',
                                'Lituânia' => 'Lituânia',
                                'Mônaco' => 'Mônaco',
                                'Noruega' => 'Noruega',
                                'Holanda' => 'Holanda',
                                'Polônia' => 'Polônia',
                                'Portugal' => 'Portugal',
                                'Reino Unido' => 'Reino Unido',
                                'República Tcheca' => 'República Tcheca',
                                'Romênia' => 'Romênia',
                                'Rússia' => 'Rússia',
                                'San Marino' => 'San Marino',
                                'Sérvia' => 'Sérvia',
                                'Suécia' => 'Suécia',
                                'Suíça' => 'Suíça',
                            ])
                            ->required(),


                        TextInput::make('cep')
                            ->label('CEP')
                            ->maxLength(8)
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

                TextColumn::make('tipoImovel.nome')
                    ->label('Tipo')
                    ->sortable(),

                TextColumn::make('tipoImovel.situacao')
                    ->label('Situação')
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
                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->options([
                        'vende-se' => 'Vende-se',
                        'aluga-se' => 'Aluga-se',
                    ]),

                SelectFilter::make('tipo_id')
                    ->label('Tipo')
                    ->relationship('tipoImovel', 'nome'),

                SelectFilter::make('status_id')
                    ->label('Status')
                    ->relationship('statusImovel', 'nome'),

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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Filament::auth()->user();

        if ($user->role === 'corretor') {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Filament::auth()->user()->role === 'corretor') {
            $data['user_id'] = Filament::auth()->id();
        }

        return $data;
    }
}
