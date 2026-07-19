# Devlog API

## Sobre o projeto

API em Laravel para cadastrar e administrar experiências de desenvolvimento: problemas técnicos enfrentados, soluções aplicadas e aprendizados extraídos ao longo de projetos reais.

A ideia central: cada **Experience** (experiência) fica vinculada a um **Product** (produto/projeto), que por sua vez pertence a uma **Company** (empresa ou projeto pessoal). Cada Experience também pode estar associada a uma ou mais **Techs** (tecnologias envolvidas), num relacionamento N:N.

O projeto foi construído com foco em estudo — arquitetura em camadas (Service Layer), tipagem explícita e boas práticas de Laravel.

> Projeto pensado para rodar localmente, sem autenticação — não deve ser exposto publicamente da forma como está hoje.

## Tecnologias utilizadas

- **PHP 8.2**
- **Laravel 12**
- **MySQL 8** (via Docker)
- **Livewire** (planejado para o front-end)
- **Pest / PHPUnit** (testes)
- **Laravel Pint** (formatação de código)
- **Laravel Sanctum** (disponível, ainda não utilizado — API sem autenticação por enquanto)

## Conceitos e padrões aplicados

Alguns dos conceitos de programação orientada a objetos e boas práticas aplicados durante o desenvolvimento:

- **Service Layer** — regras de negócio isoladas em classes `App\Services\*`, mantendo os Controllers enxutos.
- **Thin Controllers** — os Controllers apenas orquestram: recebem a requisição validada, chamam o Service e devolvem a resposta HTTP.
- **Form Requests** — validação de entrada isolada em classes próprias (`App\Http\Requests\*`), fora do Controller.
- **Herança** — todas as Form Requests estendem `AuthorizedFormRequest`, uma classe base que centraliza o `authorize()` (sempre `true`, já que a API roda apenas local, sem autenticação).
- **Polimorfismo** — o Laravel resolve e chama `rules()`/`messages()` de cada Form Request de forma genérica (via o tipo base `FormRequest`), sem saber qual é a classe concreta por trás — cada uma se comporta de forma diferente em tempo de execução.
- **Injeção de Dependência** — Services injetados nos Controllers (e uns nos outros, como `TechService` dentro de `ExperienceService`) via constructor property promotion do PHP 8.
- **UUID como chave pública** — todo recurso possui um `id` interno (auto incremento) e um `uuid`, sendo o `uuid` a chave usada nos relacionamentos e exposta nas rotas/URLs.
- **Transações de banco (`DB::transaction`)** — usadas em operações que envolvem múltiplos passos que precisam ser todos concluídos ou rollback (ex: criar uma Experience e vincular suas Techs).
- **find-or-create** — ao cadastrar uma Experience, as Techs informadas são reaproveitadas se já existirem (por nome) ou criadas automaticamente caso contrário.

## Como rodar o projeto

### Pré-requisitos

- PHP 8.2+
- Composer
- Docker (para o banco de dados MySQL)
- Node.js (para os assets do front-end)

### Passo a passo

1. Clone o repositório e acesse a pasta do projeto.

2. Copie o arquivo de ambiente:
   ```bash
   cp .env.example .env
   ```

3. Suba o banco de dados MySQL via Docker:
   ```bash
   docker-compose up -d
   ```

4. Instale as dependências PHP:
   ```bash
   composer install
   ```

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Rode as migrations:
   ```bash
   php artisan migrate
   ```

7. Suba o servidor local:
   ```bash
   php artisan serve
   ```

A API estará disponível em `http://localhost:8000/api`.

> Alternativa: o comando `composer run dev` sobe o servidor Laravel, o worker de filas e o Vite simultaneamente.

## Documentação dos endpoints

Todos os endpoints abaixo esperam (e retornam) `application/json`. Recomenda-se sempre enviar o header `Accept: application/json`.

### Companies

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/companies` | Lista todas as companies |
| POST | `/api/companies` | Cria uma nova company |
| GET | `/api/companies/{uuid}` | Exibe uma company específica |
| PUT/PATCH | `/api/companies/{uuid}` | Atualiza uma company |
| DELETE | `/api/companies/{uuid}` | Remove uma company (204 No Content) |

**Body de criação (`POST`):**
```json
{
    "name": "Empresa Exemplo Ltda",
    "website": "https://www.exemplo.com",
    "start_date": "2020-01-15",
    "end_date": "2023-06-30"
}
```
- `name`: obrigatório.
- `website`: opcional, deve ser uma URL válida e ativa.
- `start_date`: obrigatório, deve ser uma data no passado.
- `end_date`: opcional, deve ser uma data no passado e posterior a `start_date`.
- No `update`, todos os campos são opcionais (o vínculo/estrutura não muda, só os dados).

### Products

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/products` | Lista todos os products |
| POST | `/api/products` | Cria um novo product |
| GET | `/api/products/{uuid}` | Exibe um product específico |
| PUT/PATCH | `/api/products/{uuid}` | Atualiza um product |
| DELETE | `/api/products/{uuid}` | Remove um product (204 No Content) |

**Body de criação (`POST`):**
```json
{
    "name": "Devlog API",
    "description": "API para registrar experiências de dev",
    "website": "https://github.com/usuario/devlog",
    "git_source": "https://github.com/usuario/devlog",
    "company_id": "<uuid de uma company existente>"
}
```
- `name`, `description`, `company_id`: obrigatórios. `company_id` precisa ser o UUID de uma company já cadastrada.
- `website`, `git_source`: opcionais, devem ser URLs válidas.
- No `update`, `company_id` não pode ser alterado (vínculo imutável); demais campos são opcionais.

### Experiences

| Método | Endpoint | Descrição |
|---|---|---|
| GET | `/api/experiences` | Lista todas as experiences |
| POST | `/api/experiences` | Cria uma nova experience |
| GET | `/api/experiences/{uuid}` | Exibe uma experience específica |
| PUT/PATCH | `/api/experiences/{uuid}` | Atualiza uma experience |
| DELETE | `/api/experiences/{uuid}` | Remove uma experience (204 No Content) |

**Body de criação (`POST`):**
```json
{
    "title": "Bug de N+1 no Eloquent",
    "problem": "Query lenta ao listar experiences com techs",
    "solution": "Uso de eager loading com with()",
    "learned": "Sempre checar o log de queries em dev",
    "category": "performance",
    "product_id": "<uuid de um product existente>",
    "techs": ["Laravel", "MySQL"]
}
```
- `title`, `problem`, `solution`, `learned`, `category`, `product_id`: obrigatórios.
- `techs`: opcional, array de strings com o **nome** de cada tecnologia. Cada nome é buscado no banco — se já existir uma Tech com aquele nome, ela é reaproveitada; se não existir, é criada automaticamente e vinculada.
- No `update`, `product_id` e `techs` não podem ser alterados (vínculos imutáveis); demais campos são opcionais.

### Techs

> ⚠️ Ainda não implementado — ver checklist abaixo. As rotas já existem devido o (`Route::apiResources`).

## Checklist

### Feito
- [x] Estrutura de rotas da API (`routes/api.php`)
- [x] CRUD completo de **Company**
- [x] CRUD completo de **Product**
- [x] CRUD completo de **Experience**, incluindo vínculo N:N com Techs (find-or-create automático)
- [x] Camada de Services (`CompanyService`, `ProductService`, `ExperienceService`, `TechService`)
- [x] Form Requests com validação e mensagens customizadas para Company, Product e Experience
- [x] Classe base `AuthorizedFormRequest` (herança/polimorfismo)

### Falta fazer
- [ ] Endpoints do **Tech** (`index`, `store`, `show`, `update`, `destroy`)
- [ ] Front-end (Livewire)
