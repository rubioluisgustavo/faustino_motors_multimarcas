# faustino_motors_multimarcas

## Estrutura OO

O projeto usa uma entrada unica com roteador global e uma camada `app/` para concentrar regras de dominio e acesso ao banco:

- `index.php`: front controller unico para site e admin.
- `app/Router.php`: roteia URLs publicas e administrativas.
- `app/Models`: entidades do sistema (`Marca`, `Modelo`, `Opcional`, `Veiculo`, `Usuario`).
- `app/Controllers`: prepara dados para as telas publicas.
- `app/Controllers/Admin`: controllers do painel administrativo.
- `app/Repositories`: consultas e comandos SQL por entidade.
- `app/Services`: servicos de apoio, como upload de imagem de veiculo.
- `app/Views`: templates publicos e componentes compartilhados.
- `app/Views/admin`: layout, dashboard, login e telas do painel administrativo.
- `app/Support`: helpers de URL, escape, formatacao e renderizacao de views.
- `app/bootstrap.php`: carrega a configuracao de banco e registra o autoload das classes `App\`.
- `config/database.php`: configuracao PDO do banco.
- `public/assets/css`: CSS publico, admin e login.

As telas publicas e administrativas ficam em `app/Views`, as regras em controllers e o SQL apenas em repositories.
Em ambiente local/CLI o banco usa a configuracao local; fora disso, a conexao espera variaveis de ambiente `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`.

## Organizacao atual

- A raiz publica ficou reduzida a `index.php`, `.htaccess`, `README.md`, `config/`, `app/` e assets em `public/`.
- Os CSS administrativos duplicados por modulo foram consolidados em `public/assets/css/admin.css`.
- A pasta `admin/` fisica foi removida; as rotas do painel agora passam pelo roteador global em `index.php`.
- Links internos usam helpers de base URL ou caminhos relativos, evitando dependência do antigo `/new/`.

## Rotas principais

- `/`: estoque com filtros.
- `/empresa`: pagina institucional.
- `/veiculo/{id}`: detalhes de um veiculo.
- `/admin`: dashboard administrativo.
- `/admin/login`: login do painel.
- `/admin/logout`: sair do painel.
- `/admin/marcas`, `/admin/modelos`, `/admin/opcionais`, `/admin/veiculos`: modulos administrativos.
