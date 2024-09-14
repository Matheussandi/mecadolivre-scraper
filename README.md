# Web Scraping - Mercado Livre
https://github.com/user-attachments/assets/4c57120b-909a-4096-845b-a768346d8517

## Descrição

Este projeto realiza web scraping na página do Mercado Livre para coletar informações sobre produtos, como título, preço antigo e preço novo. Os dados coletados são armazenados em um banco de dados e podem ser exportados em formato CSV.

## Funcionalidades

- Coleta de dados de produtos do Mercado Livre
- Armazenamento dos dados em um banco de dados
- Exportação dos dados em formato CSV

### Pré-requisitos

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Node.js](https://nodejs.org/) e [npm](https://www.npmjs.com/)

## Instalação

### Passos

1. Clone o repositório:
    ```sh
    git clone git@github.com:Matheussandi/mecadolivre-scraper.git
    cd mecadolivre-scraper
    ```

2. Configure o arquivo `.env` com as informações do banco de dados.

3. Construa e inicie os containers Docker:
    ```sh
    docker compose up --build -d
    ```

4. Execute as migrações:
    ```sh
    docker compose exec app php artisan migrate
    ```

5. Instale as dependências do frontend e inicie o servidor de desenvolvimento:
    ```sh
    npm install
    npm run dev
    ```

## Uso

Após a instalação, você pode acessar a aplicação em seu navegador no endereço `http://localhost:8000`. Use as credenciais de login ou registre-se para acessar as funcionalidades da aplicação.

## Rotas

| Nome        | Descrição                              | Rota            |
|-------------|----------------------------------------|-----------------|
| Scraping    | Inicia o scraping dos produtos         | `/scrape`       |
| Listagem    | Visualiza os produtos coletados        | `/products`     |
| Exportação  | Exporta os produtos coletados em CSV   | `/export-csv`   |

## Licença

Este projeto é licenciado sob a [MIT License](https://opensource.org/licenses/MIT).