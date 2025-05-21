# 📦 Laravel Docker Boilerplate — Order Tracking API

Este projeto é um ambiente Docker para execução de uma API Laravel de rastreamento de pedidos.

## 🗂 Estrutura do Projeto

```bash
docker_laravel/
├── Dockerfile
└── order-tracking (projeto Laravel)/
├── README.md
└── pos_subida.txt
```
---

## 🚀 Passo a passo para rodar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/claudecirmiranda/docker_laravel.git
cd docker_laravel
```

2. Compilar a imagem Docker

```
docker build -f Dockerfile -t php-laravel:8.3 .
```

3. Entrar na pasta do projeto Laravel

```
cd order-tracking
```

4. Subir os containers

```
docker-compose up -d
```

🐳 Acessar o container Laravel

```
docker exec -it laravel-app bash
```

5. Executar os comandos de setup da aplicação

```
1. Limpa o terminal (opcional)
clear

2. Instala dependências do Composer
composer install

3. Gera a chave da aplicação
php artisan key:generate

4. Cria pastas necessárias para armazenamento de views (se não existir)
mkdir -p storage/framework/views

5. Ajusta permissões nas pastas de armazenamento
chmod -R 775 storage bootstrap/cache

6. Ajusta o proprietário das pastas (substitua 'www-data' pelo usuário do seu servidor web, se necessário)
sudo chown -R www-data:www-data storage bootstrap/cache

7. Limpa caches e configurações para garantir um ambiente limpo
php artisan config:clear
php artisan cache:clear
php artisan view:clear

8. Executa as migrções (certifique-se de que o banco está configurado corretamente)
php artisan migrate

9. (Opcional) verificar o usuário do servidor web
ps aux | egrep '(apache|nginx)'

```

✅ Testes da API

➕ Criar novo pedido

```
curl --location 'http://localhost:8080/order-tracking/api/order' \
--header 'Content-Type: application/json' \
--data '{
    "order_id": "123",
    "channel": "CPR",
    "origin": {
        "zipcode": "50950-170",
        "title": "Unidade Matriz"
    },
    "destination": {
        "zipcode": "50950-170",
        "city": "João Pessoa",
        "state": "PB"
    }
}'
```

🚚 Atualizar tracking do pedido

```
curl --location 'http://localhost:8080/order-tracking/api/order/tracking' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--data '{
    "order_id": "123",
    "tracking": [
        {
            "step": "recebido",
            "status": "Pedido recebido",
            "message": "Pedido foi recebido",
            "observation": "O pedido foi recebido",
            "created_at": "2025-05-20T12:00:00"
        }
    ]
}'
```

🌐 Testes via Navegador

🔐 Gerar hash

Acesse no navegador:

```
http://localhost:8080/order-tracking/123/CPR
```

🔍 Consultar tracking com hash
Copie o hash gerado e acesse:

```
http://localhost:8080/order-tracking/aWQ9MTIzJmNoPUNQUiZoYXNoPTQ3NTM0ZmU3NjQ1MDhhZjI1ZjViZDRmZDUwMmMwMGFk
```

📄 Licença
----------

Este projeto está sob a licença MIT.
