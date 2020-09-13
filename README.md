# EngHaw Crawlers
Crawlers que capturam letras de músicas dos Engenheiros do Hawaii / Pouca Vogal / Humberto Gessinger de sites de músicas.

---
## Configuração do Ambiente
A configuração do ambiente é feita via `docker` utilizando `docker-compose`.

O `docker` possui os seguintes containers:

- `enghaw-crawlers-php-fpm` => Container do PHP na versão `7.4 (FPM)` (Esse container já dispõe de `Composer` na versão `latest`)

Para executar todos os containers, utilizar `docker-compose up -d`

---
## Configuração da Aplicação:
- Copiar o arquivo `.env.example` para `.env` (Caso tenha necessidade, trocar as variáveis do `.env`)
- Instalar os pacotes da aplicação `composer install`
- Gerar a chave da aplicação com `php artisan key:generate`

---
## Servindo a Aplicação
Caso não tenha alterado a variável `ENGHAW_API_HOST` no `.env` (Essa variável deve ser apontada para a URL do `enghaw-api`)

---
## Crawlers Existentes
- `vagalume` => Capta as letras do site Vagalume

Para executar um crawler basta digitar o comando `php artisan crawler:start nome-crawler` (`nome-crawler` = Crawler dentro da lista `Crawlers Existentes`)
