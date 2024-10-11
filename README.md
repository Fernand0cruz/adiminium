
# Sistema de Gerenciamento de Produtos e Clientes

## Descrição

Este sistema de **Gerenciamento de Produtos e Clientes** foi desenvolvido utilizando o framework [Laravel](https://laravel.com), permitindo que administradores cadastrem produtos e clientes, enquanto clientes autenticados podem fazer pedidos dos produtos disponíveis. O sistema oferece uma interface simples para gerenciamento de usuários, produtos e pedidos.

![Interface de Administração](https://utfs.io/f/ADlkNHdwCbB3nYWCuSiKCEYMHP7V0L2y5IaJmbtNv6wfdDpc)

## Funcionalidades

- **Administração de produtos**: cadastro, edição e exclusão de produtos.
- **Gerenciamento de clientes**: cadastro de clientes e pedidos.
- **Autenticação**: sistema de login para clientes e administrador.
- **Pedidos de produtos**: clientes podem fazer pedidos de produtos disponíveis.
  
## Nota de Atenção

Ao rodar o sistema com Docker, as **migrations** serão executadas automaticamente, juntamente com o **seeding** do banco de dados. Isso criará dois usuários:

- **Admin**: um único usuário administrador com as seguintes credenciais:
  - **Email**: admin@gmail.com
  - **Senha**: admin
- **Usuário**: um perfil de cliente comum com as seguintes credenciais:
  - **Email**: user@gmail.com
  - **Senha**: user

## Requisitos

- Docker
- Docker Compose

## Instalação

### Rodando com Docker

Siga os passos abaixo para rodar o projeto utilizando Docker:

1. Clone o repositório:
   ```bash
   git clone https://github.com/Fernand0cruz/adiminium.git
   cd adiminium
   ```

2. Crie o arquivo `.env`:
   ```bash
   cp .env.example .env
   ```

3. Construa e inicie os containers Docker:
   ```bash
   docker-compose up -d --build
   ```

4. Acesse o container da aplicação:
   ```bash
   docker-compose exec app bash
   ```

5. Execute as migrations e seeds para configurar o banco de dados:
   ```bash
   php artisan db:seed
   ```

O sistema estará disponível em `http://localhost` com os usuários padrão criados automaticamente.

## Tecnologias Utilizadas

- Laravel
- Vue
- MySQL
- Docker
- Docker Compose

## Acesso

- **Admin**: [http://localhost/login](http://localhost/login)
  - **Email**: admin@gmail.com
  - **Senha**: admin
- **Usuário**: [http://localhost/login](http://localhost/login)
  - **Email**: user@gmail.com
  - **Senha**: user
