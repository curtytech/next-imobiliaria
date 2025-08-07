# Factories do Sistema Imobiliário

Este diretório contém as factories para geração de dados de teste para todas as entidades do sistema.

## Factories Disponíveis

### UserFactory
Cria usuários com dados realistas incluindo:
- Nome, email, telefone
- Descrição opcional
- Foto opcional
- CRECI para corretores
- Roles (admin/corretor)

**Métodos de estado:**
- `admin()` - Cria usuário administrador
- `corretor()` - Cria usuário corretor com CRECI
- `unverified()` - Cria usuário não verificado

**Exemplos:**
```php
// Usuário básico
User::factory()->create();

// Administrador
User::factory()->admin()->create();

// 5 corretores
User::factory(5)->corretor()->create();
```

### TipoImovelFactory
Cria tipos de imóveis baseados nos tipos reais do sistema.

**Exemplo:**
```php
// Tipo aleatório
TipoImovel::factory()->create();

// Tipo específico
TipoImovel::factory()->create(['nome' => 'Casa']);
```

### StatusImovelFactory
Cria status de imóveis (Disponível, Vendido, Alugado, etc.).

**Exemplo:**
```php
// Status aleatório
StatusImovel::factory()->create();

// Status específico
StatusImovel::factory()->create(['nome' => 'Disponível']);
```

### ImovelFactory
Cria imóveis completos com todos os campos e relacionamentos.

**Métodos de estado:**
- `featured()` - Marca como destaque
- `available()` - Define como disponível
- `house()` - Configura como casa (com terreno)
- `apartment()` - Configura como apartamento (com condomínio)

**Exemplos:**
```php
// Imóvel básico
Imovel::factory()->create();

// Imóvel em destaque
Imovel::factory()->featured()->create();

// 10 casas disponíveis
Imovel::factory(10)->house()->available()->create();

// Apartamento específico
Imovel::factory()->apartment()->create([
    'titulo' => 'Apartamento Luxo',
    'preco' => 500000.00
]);
```

## Uso nos Seeders

As factories são utilizadas nos seeders para manter consistência e facilitar manutenção:

```php
// Em vez de criar manualmente
Imovel::create([
    'titulo' => 'Casa',
    'preco' => 300000,
    // ... muitos campos
]);

// Use a factory
Imovel::factory()->create([
    'titulo' => 'Casa',
    'preco' => 300000
]);
```

## Vantagens das Factories

1. **Consistência**: Dados sempre válidos e realistas
2. **Manutenibilidade**: Mudanças no modelo refletidas automaticamente
3. **Flexibilidade**: Métodos de estado para cenários específicos
4. **Testes**: Facilita criação de dados para testes
5. **Performance**: Geração eficiente de grandes volumes de dados

## Executando os Seeders

```bash
# Todos os seeders
php artisan db:seed

# Seeder específico
php artisan db:seed --class=ImovelSeeder

# Resetar e popular
php artisan migrate:fresh --seed
```