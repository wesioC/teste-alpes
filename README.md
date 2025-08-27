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

1. Clone o repositório no EC2:

2. Copie o arquivo de ambiente e configure variáveis:

```bash
cp .env.example .env
nano .env
```

Configure:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=
DB_PASSWORD=
```

3. Instale dependências:

```bash
composer install 
```

4. Gere a chave da aplicação:

```bash
php artisan key:generate
```


6. Ajuste permissões se precisar (para logs e cache):

```bash
sudo chown -R apache:apache storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

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

Para agendar via cron (caso não esteja configurado):

```bash
* * * * * cd /var/www/teste-alpes && php artisan schedule:run >> /dev/null 2>&1
```

> Isso fará com que o Laravel execute automaticamente o comando de importação conforme definido no Kernel (`hourly`).

---

## 🔹 Rodar a aplicação e testes

1. Com Nginx e PHP-FPM já configurados, a aplicação estará disponível em:  

```
https://alpes.wesio.online
```

2. Limpar e gerar caches:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Rodar testes :

```bash
php artisan test
```

---

## 🔹 Deploy

- **Automático via GitHub Actions**: o workflow atual faz pull do `main`, instala dependências e limpa caches.  
- **Manual**: execute o script de deploy:

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
