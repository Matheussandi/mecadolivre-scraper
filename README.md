# Web Scraping - Mercado Livre

## Descrição

Este projeto realiza web scraping na página do Mercado Livre para coletar informações sobre produtos, como título, preço e tipo. Os dados coletados são armazenados em um banco de dados e podem ser exportados em formato CSV.

## Funcionalidades

- Coleta de dados de produtos do Mercado Livre
- Armazenamento dos dados em um banco de dados
- Exportação dos dados em formato CSV

## Requisitos

- Docker
- Docker Compose

## Instalação

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

## Uso

| Nome        | Descrição                              | Rota            |
|-------------|----------------------------------------|-----------------|
| Scraping    | Inicia o scraping dos produtos         | `/scrape`       |
| Listagem    | Visualiza os produtos coletados        | `/products`     |
| Exportação  | Exporta os produtos coletados em CSV   | `/export-csv`   |

## Licença

Este projeto é licenciado sob a [MIT License](https://opensource.org/licenses/MIT).