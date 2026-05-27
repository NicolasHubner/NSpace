# NSpace

Marketplace de aluguel de espaços para eventos (salões, auditórios, espaços corporativos,
campos/quadras, casas de praia, sítios, espaços para festas, estúdios, etc.). Anunciantes
cadastram propriedades; clientes buscam, reservam e pagam online.

<img width="1600" height="823" alt="image" src="https://github.com/user-attachments/assets/9422cffc-6538-4e47-9044-f8fedf4d862a" />

> **Projeto legado.** Aplicação antiga (~2019), recuperada de um backup completo de cPanel
> de março/2022. Stack já obsoleta. Mantido aqui para arquivo histórico e referência.

## Stack

| Camada | Tecnologia |
|---|---|
| Linguagem | PHP (testado rodando em PHP 7.4) |
| ORM | Doctrine 1.x (descontinuado desde ~2013) |
| Banco | MySQL 5.x |
| Front | HTML/CSS/JS server-rendered, jQuery |
| Pagamentos | PagSeguro |
| Login social | Google OAuth, Facebook SDK (Graph v12) |
| Email | PHPMailer (SMTP) |
| Imagens | WideImage (requer extensão GD) |
| Hospedagem original | cPanel (`nspaceco`, domínio nspace.com.br) |

Sem Composer no fluxo de runtime — dependências vendoradas em `vendor/` e `lib/`.

## Estrutura

```
index.php              # Home
lib/Config.php         # Config por ambiente (PATH/URL/DB/SMTP) + bootstrap
bootstrap.php          # Inicializa Doctrine (conexão + autoload de models)
models/                # Models Doctrine
action/                # Endpoints de ação (POST handlers)
administrador/         # Painel admin
area-cliente/          # Área do cliente
anuncio*.php           # Listagem e detalhe de anúncios
planos.php, pagamento*.php, reserva.php   # Planos, pagamento, reserva
.htaccess              # Rewrite de URLs amigáveis + (orig.) redirect https/www
```

## Rodar localmente (Docker)

A aplicação precisa de MySQL + PHP com extensões `pdo_mysql`, `mysqli` e `gd`.
O dump do banco está no backup em `mysql/nspaceco_banco.sql`.

### 1. Banco

```bash
docker run -d --name nspace-db --network host \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=nspaceco_banco \
  -e MYSQL_USER=nspaceco_usuario \
  -e MYSQL_PASSWORD=usuario02320br \
  mysql:5.7
# aguarde o banco subir, depois carregue o dump:
docker exec -i nspace-db mysql -uroot -proot nspaceco_banco < mysql/nspaceco_banco.sql
```

### 2. PHP + Apache

```bash
docker run -d --name nspace-php --network host \
  -e NSPACE_LOCAL_DEV=1 \
  -e APACHE_RUN_USER="#$(id -u)" -e APACHE_RUN_GROUP="#$(id -g)" \
  -v "$PWD":/home/nspaceco/public_html \
  -w /home/nspaceco/public_html \
  php:7.4-apache bash -c "\
    apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install pdo pdo_mysql mysqli gd && \
    a2enmod rewrite && \
    rm -rf /var/www/html && ln -s /home/nspaceco/public_html /var/www/html && \
    sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf && \
    sed -i 's/:80>/:8080>/' /etc/apache2/sites-enabled/000-default.conf && \
    sed -i 's#AllowOverride None#AllowOverride All#g' /etc/apache2/apache2.conf && \
    apache2-foreground"
```

Acesse: <http://localhost:8080/>

### Adaptações para rodar local

- `lib/Config.php`: adicionado um branch de ambiente ativado pela env var
  `NSPACE_LOCAL_DEV=1` (DB em `127.0.0.1`, sem redirect forçado de domínio).
- `.htaccess`: os redirects de `https`/`www` foram comentados para uso local.

## Notas

- Uploads de usuários (`images/anuncio`, `images/cliente`, etc.) e o código antigo
  em `site-antigo/dev` ficam fora do versionamento (ver `.gitignore`) — são dados de
  runtime / legado pesado.
- Há credenciais hardcoded em `lib/Config.php` (padrão da época). Trocar antes de
  qualquer reuso real.
