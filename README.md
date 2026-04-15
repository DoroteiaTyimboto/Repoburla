# Sistema de Combate a Burlas Digitais

Sistema completo em Laravel para identificar, reportar e combater fraudes digitais com educação contínua e ferramentas avançadas.

## Funcionalidades Implementadas

### 1. **Autenticação e Autorização**
- ✅ Registro de usuários com validação
- ✅ Login seguro com sessões
- ✅ Gerenciamento de perfil
- ✅ Controle de acesso (user, moderator, admin)

### 2. **Sistema de Denúncias**
- ✅ Criação de denúncias com múltiplos tipos (phishing, malware, fraude, etc)
- ✅ Visualização e filtro de denúncias
- ✅ Moderação e aprovação de denúncias
- ✅ Sistema de comentários
- ✅ Avaliações e classificações
- ✅ Rastreamento de status (pendente, aprovado, rejeitado, resolvido)

### 3. **Cursos de Educação**
- ✅ Catálogo de cursos por nível (iniciante, intermediário, avançado)
- ✅ Inscrição e progressão de cursos
- ✅ Sistema de comentários em cursos
- ✅ Avaliações de cursos
- ✅ Rastreamento de conclusão
- ✅ Painel admin para gerenciar cursos

### 4. **Testador de Links**
- ✅ Verificação de segurança de URLs
- ✅ Detecção de padrões suspeitos
- ✅ Verificação SSL
- ✅ Histórico de testes
- ✅ Classificação de risco (seguro, suspeito, perigoso)
- ✅ API para testes automáticos

### 6. **Dashboard e Estatísticas**
- ✅ Dashboard do usuário com estatísticas pessoais
- ✅ Dashboard administrativo com métricas do sistema
- ✅ Relatórios de atividade
- ✅ Notificações do sistema

### 7. **Administração**
- ✅ Gerenciamento de usuários
- ✅ Gerenciamento de denúncias
- ✅ Gerenciamento de cursos
- ✅ Sistema de notificações em massa
- ✅ Relatórios detalhados

### 8. **Funcionalidades Adicionais**
- ✅ Mapa com localização de denúncias
- ✅ Suporte multilíngue (PT/EN)
- ✅ Responsivo em todos os dispositivos
- ✅ Segurança com CSRF protection
- ✅ Validação de entrada em todos os formulários
- ✅ Hash seguro de senhas com bcrypt

## Requisitos do Sistema

- PHP >= 8.2
- MySQL >= 8.0 ou SQLite
- Composer
- Node.js e NPM (opcional, para assets)

## Instalação

### 1. Clonar o repositório
```bash
git clone <seu-repositorio>
cd burlas-digitais
```

### 2. Instalar dependências
```bash
composer install
```

### 3. Configurar arquivo .env
```bash
cp .env.example .env
php artisan key:generate
```

Edite o `.env` com suas configurações de banco de dados:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=burlas_digitais
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Criar banco de dados
```bash
mysql -u root -p
CREATE DATABASE burlas_digitais;
EXIT;
```

### 5. Executar migrations
```bash
php artisan migrate
```

### 6. Semear dados iniciais (opcional)
```bash
php artisan db:seed
```

### 7. Iniciar o servidor
```bash
php artisan serve
```

Acesse em: `http://localhost:8000`

## Estrutura do Projeto

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Controllers da aplicação
│   │   └── Middleware/           # Middlewares personalizados
│   ├── Models/                   # Modelos Eloquent
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Migrations do banco de dados
│   └── seeders/                  # Database seeders
├── resources/
│   ├── views/                    # Templates Blade
│   ├── lang/                     # Arquivos de idioma
│   └── css/                      # Estilos (Bootstrap)
├── routes/
│   ├── web.php                   # Rotas web
│   └── api.php                   # Rotas API
├── config/                       # Arquivos de configuração
└── storage/                      # Arquivos upados e logs
```

## Endpoints Principais

### Públicos
- `GET /` - Homepage
- `GET /denuncias` - Listar denúncias
- `GET /cursos` - Listar cursos
- `GET /mapa` - Mapa de denúncias
- `GET /login` - Página de login
- `GET /registro` - Página de registro

### Autenticados
- `GET /dashboard` - Dashboard do usuário
- `POST /denuncias` - Criar denúncia
- `GET /denuncias/{id}` - Ver denúncia
- `POST /cursos/{id}/inscrever` - Inscrever em curso
- `POST /testador-links/testar` - Testar URL
- `GET /perfil` - Editar perfil

### Admin
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/usuarios` - Gerenciar usuários
- `GET /admin/denuncias` - Gerenciar denúncias
- `GET /admin/cursos` - Gerenciar cursos
- `GET /admin/relatorios` - Ver relatórios

## Modelos de Dados

### User
- id, name, email, password, phone, country, role, is_active, timestamps

### Denuncia
- id, user_id, titulo, descricao, tipo, url_suspeita, evidencias, status, prioridade, impacto_estimado, tags, localizacao, data_incidente, resultado_verificacao, moderador_id, data_resolucao, timestamps

### Curso
- id, titulo, descricao, conteudo, nivel, duracao_minutos, categoria, imagem_capa, instrucoes, tags, is_published, ordem, timestamps

### TestadorLink
- id, user_id, url_testada, resultado, classificacao_risco, detalhes_verificacao, tempo_verificacao, ip_destino, certificado_ssl, reputacao_dominio, timestamps

### Comentario
- id, user_id, denuncia_id/curso_id, conteudo, é_resposta, comentario_pai_id, é_moderado, moderador_id, timestamps

### Avaliacao
- id, user_id, denuncia_id/curso_id, classificacao, comentario, tipo_recurso, timestamps

### Notificacao
- id, user_id, tipo, titulo, mensagem, url, é_lida, dados_adicionais, timestamps

## Segurança

- ✅ CSRF Protection em todos os formulários
- ✅ Validação de entrada em todos os endpoints
- ✅ Hash bcrypt para senhas
- ✅ Sanitização de output contra XSS
- ✅ Autorização baseada em roles
- ✅ SQL Injection prevention com Eloquent ORM

## API Endpoints

A aplicação possui endpoints REST para integração com aplicações móveis:

```
GET    /api/denuncias
GET    /api/denuncias/{id}
POST   /api/denuncias
GET    /api/cursos
GET    /api/cursos/{id}
POST   /api/testador-links/testar
GET    /api/testador-links
```

## Próximos Passos

1. **PDF Reports** - Gerar relatórios em PDF
2. **PWA** - Implementar Progressive Web App
3. **Email Notifications** - Sistema de notificações por email
4. **API Documentation** - Documentação completa da API
5. **Testes Automatizados** - PHPUnit tests
6. **Cache** - Implementar caching com Redis
7. **Background Jobs** - Queue para processamento assíncrono

## Créditos

Desenvolvido como um sistema completo de combate a burlas digitais com foco em educação, prevenção e reportagem.

## Licença

MIT License

## Suporte

Para reportar problemas ou sugerir melhorias, abra uma issue no repositório.

---

**Versão:** 1.0.0  
**Última Atualização:** 2024
