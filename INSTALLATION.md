# Guia de Instalação - Sistema de Combate a Burlas Digitais

## Pré-requisitos

Certifique-se de ter instalado:

- **PHP >= 8.2** (com extensões: pdo, pdo_mysql, mbstring, tokenizer, xml)
- **Composer** (https://getcomposer.org/)
- **MySQL >= 8.0** ou **SQLite**
- **Node.js & NPM** (opcional, para assets)
- **Git** (opcional, para clonar o projeto)

## Passo 1: Preparar o Projeto

### Opção A: Clonando do Repositório
```bash
git clone <seu-repositorio>
cd burlas-digitais
```

### Opção B: Usando o Arquivo ZIP
```bash
unzip burlas-digitais.zip
cd burlas-digitais
```

## Passo 2: Instalar Dependências PHP

```bash
composer install
```

Isso irá instalar todos os pacotes PHP necessários listados no `composer.json`.

## Passo 3: Configurar o Arquivo .env

```bash
cp .env.example .env
```

Gere a chave da aplicação:
```bash
php artisan key:generate
```

Edite o arquivo `.env` com suas configurações:

### Para MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=burlas_digitais
DB_USERNAME=seu_usuario_mysql
DB_PASSWORD=sua_senha_mysql

APP_NAME="Sistema de Combate a Burlas Digitais"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Para SQLite (mais simples para desenvolvimento):
```env
DB_CONNECTION=sqlite
DB_DATABASE=/caminho/absoluto/para/database.sqlite

APP_NAME="Sistema de Combate a Burlas Digitais"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

## Passo 4: Criar o Banco de Dados

### Para MySQL:
```bash
mysql -u root -p
CREATE DATABASE burlas_digitais;
EXIT;
```

### Para SQLite:
A aplicação criará o arquivo automaticamente ao executar as migrations.

## Passo 5: Executar Migrations

```bash
php artisan migrate
```

Isso irá criar todas as tabelas necessárias no banco de dados.

## Passo 6: Semear Dados Iniciais (Opcional)

Para popular o banco com dados de teste:

```bash
php artisan db:seed
```

Dados criados:
- **Admin**: email: admin@example.com / senha: password123
- **Moderador**: email: moderador@example.com / senha: password123
- **Usuário**: email: user@example.com / senha: password123
- 3 cursos de exemplo
- 2 denúncias de exemplo

## Passo 7: Iniciar o Servidor

### Opção A: Usando o servidor built-in do Laravel:
```bash
php artisan serve
```

A aplicação estará disponível em: **http://localhost:8000**

### Opção B: Usando Laravel Herd (recomendado):
```bash
herd link
```

Acesse através do domínio gerado.

### Opção C: Usando Docker Compose (se disponível):
```bash
docker-compose up -d
php artisan migrate
php artisan db:seed
```

## Passo 8: Acessar a Aplicação

Abra o navegador e acesse:
```
http://localhost:8000
```

## Primeiro Acesso

1. Clique em "Login" ou "Registrar"
2. Se usou o seed, use as credenciais:
   - Admin: `admin@example.com` / `password123`
   - User: `user@example.com` / `password123`
3. Ou crie uma nova conta através do formulário de registro

## Estrutura de Diretórios

```
burlas-digitais/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Controladores da aplicação
│   │   └── Middleware/       # Middlewares personalizados
│   ├── Models/               # Modelos Eloquent
│   └── Providers/            # Service providers
├── database/
│   ├── migrations/           # Migrations do banco
│   └── seeders/              # Dados iniciais
├── resources/
│   ├── views/                # Templates Blade
│   ├── lang/                 # Arquivos de idioma
│   └── css/                  # Estilos
├── routes/
│   ├── web.php               # Rotas web
│   └── api.php               # Rotas API
├── config/                   # Configurações
├── storage/                  # Arquivos upados e logs
├── tests/                    # Testes
└── vendor/                   # Dependências PHP
```

## Configurações Adicionais

### Configurar Email (opcional)

Edite o `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_username
MAIL_PASSWORD=sua_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@burlas-digitais.com
```

### Configurar Storage Público

```bash
php artisan storage:link
```

Cria um symlink para servir arquivos do storage publicamente.

### Configurar Cache

Para usar Redis (opcional):
```env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Troubleshooting

### Erro: "No application key has been generated"
```bash
php artisan key:generate
```

### Erro: "SQLSTATE[HY000] [2002] Connection refused"
- Verifique se MySQL está rodando
- Verifique as credenciais no `.env`
- Para SQLite, verifique se o arquivo tem permissão de escrita

### Erro: "Migrations are not up to date"
```bash
php artisan migrate:refresh
php artisan db:seed
```

### Permissões de Arquivo/Diretório
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## Desenvolvimento

### Executar Testes
```bash
php artisan test
```

### Gerar Documentação
```bash
php artisan tinker
```

### Limpar Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Deploy em Produção

1. Clone o repositório
2. Configure `.env` para produção
3. Execute: `composer install --no-dev`
4. Execute: `php artisan migrate --force`
5. Execute: `php artisan config:cache`
6. Execute: `php artisan route:cache`
7. Execute: `php artisan view:cache`
8. Configure o servidor web (Nginx/Apache)
9. Configure SSL/HTTPS
10. Configure backups automáticos

## Suporte

Para problemas na instalação, consulte:
- Documentação Laravel: https://laravel.com/docs
- Issues do repositório
- Contacte suporte@burlas-digitais.com

---

**Versão**: 1.0.0  
**Última Atualização**: 2024
