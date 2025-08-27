# Carros API

API RESTful para gerenciar carros, desenvolvida em **Laravel 11** e hospedada em **https://alpes.wesio.online**.  

Esta API permite criar, listar, atualizar, consultar e excluir carros, além de suportar importação automática via scheduler.

---

## 🔹 Endpoints

| Método | Endpoint          | Descrição                       |
|--------|-----------------|---------------------------------|
| GET    | `/api/cars`       | Listar todos os carros          |
| GET    | `/api/cars/{id}`  | Consultar carro por ID          |
| POST   | `/api/cars`       | Criar um novo carro             |
| PUT    | `/api/cars/{id}`  | Atualizar carro existente       |
| DELETE | `/api/cars/{id}`  | Excluir carro                   |

---

## 🔹 Estrutura do JSON para cadastro e update

```json
{
  "type": "carro",
  "brand": "Hyundai",
  "model": "CRETA",
  "version": "CRETA 16A ACTION",
  "year": {
    "model": 2025,
    "build": 2025
  },
  "optionals": [],
  "doors": 5,
  "board": "JCU2I93",
  "chassi": "",
  "transmission": "Automática",
  "km": 24208,
  "description": "Carro revisado",
  "sold": false,
  "category": "SUV",
  "url_car": "hyundai-creta-2025-automatica-125306",
  "price": 115900.00,
  "color": "Branco",
  "fuel": "Gasolina",
  "fotos": [
    "https://alpes-hub.s3.amazonaws.com/img1.jpeg",
    "https://alpes-hub.s3.amazonaws.com/img2.jpeg"
  ]
}
```

---
## 🔹 Configurar o ambiente

    # 1. Clone o repositório na sua máquina
    git clone https://github.com/wesioC/teste-alpes.git
    cd teste-alpes
    git pull
    git checkout dev

    # 2. Copie o arquivo de ambiente e configure variáveis
    cp .env.example .env
    nano .env

    # Configure para usar o Sail (Docker) com MySQL:
    # DB_CONNECTION=mysql
    # DB_HOST=mysql
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=sail
    # DB_PASSWORD=password

    # 3. Instale o Sail (caso ainda não esteja)
    composer require laravel/sail --dev
    php artisan sail:install

    # Escolha os serviços que deseja (MySQL, Redis, etc). Para este projeto, MySQL é suficiente.

    # 4. Suba os containers Docker
    ./vendor/bin/sail up -d
    # Isso vai criar os containers com PHP, MySQL e outros serviços configurados.

    # 5. Instale dependências do projeto
    ./vendor/bin/sail composer install --no-dev --optimize-autoloader

    # 6. Gere a chave da aplicação
    ./vendor/bin/sail artisan key:generate

    # 7. Rode as migrations e seeders
    ./vendor/bin/sail artisan migrate --seed

    # 8. Ajuste permissões para logs e cache (se necessário)
    chmod -R 775 storage bootstrap/cache

    # 9. Rodar o servidor local
    ./vendor/bin/sail artisan serve
    # A aplicação ficará disponível em http://localhost

    # 10. Rodar o scheduler ou comando de importação manualmente (opcional)
    ./vendor/bin/sail artisan schedule:run
    ./vendor/bin/sail artisan importa-carros


## 🔹 Executar o comando de importação

A importação de carros é feita via **scheduler do Laravel** (`app:importa-carros`) que roda automaticamente pelo cron.  

Para testar manualmente:

```bash
php artisan importa-carros 
```
ou 
```bash
php artisan schedule:run
```

## 🔹 Rodar a aplicação e testes

1. Limpar e gerar caches:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
2. Rodar testes :

```bash
php artisan test
```

---

## 🔹 Deploy

- **Automático via GitHub Actions**: o workflow atual faz pull do `main`, instala dependências e limpa caches.  
- **Manual**: execute o script de deploy ( é necessário ter o pem na raiz do projeto):

```bash
cd /var/www/teste-alpes
./deploy.sh
```

O script atual inclui:

```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

---

## 🔹 Collection para testes da API

Você pode importar no **Postman** usando esta variável de ambiente:

```json
{
  "id": "8a7d1b20-2c64-4b0d-9e77-123456789abc",
  "name": "Carros API Environment",
  "values": [
    {
      "key": "base_url",
      "value": "https://alpes.wesio.online",
      "enabled": true
    }
  ],
  "_postman_variable_scope": "environment",
  "_postman_exported_at": "2025-08-25T01:00:00Z",
  "_postman_exported_using": "Postman/10.21.9"
}
```

Use `{{base_url}}/api/cars` nos requests do Postman ou importe a collection que está no repositório junto ao envirioment


## 🔹 Requisitos para rodar o projeto localmente

# 1. Docker e Docker Compose
# - Laravel Sail roda em containers, então é necessário ter o Docker instalado.
# - Instale o Docker Desktop ou Docker Engine conforme seu sistema operacional.
# - Verifique instalação:
docker --version
docker-compose --version

# 2. PHP (opcional local, mas não obrigatório com Sail)
# - Sail já fornece o PHP dentro do container, mas para rodar comandos fora do container você pode ter PHP >= 8.1.
php -v

# 3. Composer (opcional local, mas não obrigatório com Sail)
# - Sail também já contém Composer dentro do container.
composer --version

# 4. Git
# - Para clonar o repositório e controlar versionamento.
git --version