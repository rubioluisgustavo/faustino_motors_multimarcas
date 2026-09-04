# faustino_motors_multimarcas

## Estrutura OO

O projeto usa uma camada `app/` para concentrar regras de dominio e acesso ao banco:

- `app/Models`: entidades do sistema (`Marca`, `Modelo`, `Opcional`, `Veiculo`, `Usuario`).
- `app/Controllers`: prepara dados para as telas publicas.
- `app/Repositories`: consultas e comandos SQL por entidade.
- `app/Services`: servicos de apoio, como upload de imagem de veiculo.
- `app/Views`: templates publicos e componentes compartilhados.
- `app/Support`: helpers de URL, escape, formatacao e renderizacao de views.
- `app/bootstrap.php`: carrega a conexao existente e registra o autoload das classes `App\`.

As paginas publicas e administrativas continuam responsaveis pela tela e pelo fluxo HTTP, mas chamam os repositórios em vez de executar SQL direto.

## Organizacao atual

- A raiz publica ficou reduzida a `index.php`, `styles.css`, `conexao.php`, `README.md` e assets em `public/`.
- Os CSS administrativos duplicados por modulo foram consolidados em `admin/css/admin.css`.
- Links internos usam helpers de base URL ou caminhos relativos, evitando dependência do antigo `/new/`.
