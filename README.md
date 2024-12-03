
# 🌟 Bem-vindo ao Adminium: A Plataforma Definitiva para Gestão de Produtos e Pedidos

## 📋 Descrição
O **Adminium** é uma solução inovadora projetada para otimizar a gestão de produtos e pedidos. Nossa plataforma oferece uma interface moderna e intuitiva, permitindo que empresas e administradores gerenciem estoques com precisão e acompanhem os pedidos em tempo real.

Desde o cadastro de produtos até a análise detalhada dos pedidos, o Adminium foi criado para melhorar fluxos de trabalho, garantir a disponibilidade de produtos e proporcionar informações valiosas para a tomada de decisões.

![Interface de Administração](https://utfs.io/f/ADlkNHdwCbB3JQl77zrfNZHzxc9FjmgI2CVMpiEosAWae1nk)

---

## 🛠️ Funcionalidades

### 👨‍💻 Para Administradores
- **Gestão de Produtos e Estoque**:
  - Cadastro e atualização de produtos no catálogo 🏷️.
  - Monitoramento preciso da quantidade disponível 📦.
- **Cadastro de Clientes**:
  - Adicionar, editar, visualizar e excluir registros de clientes 🧑‍🤝‍🧑.
- **Gestão de Pedidos**:
  - Aprovação ou recusa de pedidos ✅❌.
  - Monitoramento detalhado de todos os pedidos realizados 📑.
- **Relatórios Detalhados**:
  - Relatórios completos sobre desempenho e status do estoque 📊

### 🏢 Para Empresas
- **Catálogo de Produtos**:
  - Navegação simples e rápida pelo catálogo 📜.
  - Realização de pedidos com eficiência para garantir abastecimento contínuo 📦🔄.
- **Acompanhamento de Pedidos**:
  - Controle em tempo real sobre o status dos pedidos 📈.

---

## 🧑‍💻 Tecnologias Utilizadas
- **Backend**: Laravel 11 ⚙️ com API e **Sanctum** para autenticação 💡
- **Frontend**: Vue 3 🌐  
- **Banco de Dados**: MySQL 💾  
- **Infraestrutura**: Docker 🐳 e Docker Compose 🛠️  

---

## 📝 Requisitos
Certifique-se de ter as seguintes ferramentas instaladas antes de começar:
- **Docker**: [Instalação 🐋](https://docs.docker.com/get-docker/)
- **Docker Compose**: [Instalação 🛠️](https://docs.docker.com/compose/install/)
- **Git**: [Baixar Git](https://git-scm.com/) 🧑‍💻

---

## 🚀 Como Rodar o Projeto

### 1. Clone o Repositório
```bash
git clone https://github.com/Fernand0cruz/adminium.git
cd adminium
```

### 2. Configure o Ambiente
Crie o arquivo `.env` a partir do exemplo:
- **Windows (PowerShell)**:
  ```powershell
  Copy-Item .env.example .env
  ```
- **Windows (Prompt de Comando)**:
  ```cmd
  copy .env.example .env
  ```
- **Linux/Mac**:
  ```bash
  cp .env.example .env
  ```

### 3. Inicie o Docker
Suba os contêineres necessários:
```bash
docker compose up -d
```

### 4. Instale as Dependências
- **PHP (Composer)**:
  ```bash
  docker exec -it app composer install
  ```
- **Node.js (npm)**:
  ```bash
  docker exec -it app npm install
  ```

### 5. Compile o Frontend
Gere o build do frontend:
```bash
docker exec -it app npm run build
```

### 6. Configure a Chave da Aplicação
Gere a chave de criptografia do Laravel:
```bash
docker exec -it app php artisan key:generate
```

### 7. Crie o Link Simbólico para o Armazenamento de Arquivos
Antes de rodar o projeto, é necessário criar o link simbólico da pasta de uploads para a pasta pública do Laravel. Isso permite que os arquivos armazenados sejam acessíveis publicamente.

Execute o comando abaixo para criar o link simbólico:
```bash
docker exec -it app php artisan storage:link
```

### 8. Migre o Banco de Dados
Configure as tabelas no banco de dados:
```bash
docker exec -it app php artisan migrate
```

### 8. Ajuste Permissões
Garanta as permissões corretas para `storage` e `cache`:
```bash
docker exec -it app chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
```

---

## 🌱 Seed de Teste

Para facilitar os testes e o desenvolvimento, o sistema inclui um **seed** que cria usuários e produtos de teste no banco de dados. Isso permite que você inicie o projeto já com alguns dados inseridos, facilitando a navegação e o uso da plataforma.

![Interface de Administração](https://utfs.io/f/ADlkNHdwCbB3yXV3kdGLVrqiWk91FKuJ25pHe8mXjazds0ZY)

### 📋 Dados Gerados pelo Seed

Ao executar o comando de seed, serão gerados os seguintes dados de teste:

- **Usuário Admin**:
  - **Email**: `admin@gmail.com`
  - **Senha**: `adminpass`
  - **Papel**: Administrador

- **Usuário Comum**:
  - **Email**: `user@gmail.com`
  - **Senha**: `userpass`
  - **Papel**: Usuário

- **Produtos de Teste**:
  - Produtos serão criados no catálogo com informações fictícias para você testar o sistema.

### ⚙️ Como Rodar o Seed

Para rodar o seed e gerar os dados de teste, siga os seguintes passos:

1. **Execute o comando db:seed**:
   ```bash
   docker exec -it app php artisan db:seed
   ```

2. **Acesse o Sistema**:
   - Faça login com o **usuário admin** utilizando o email `admin@gmail.com` e a senha `adminpass` para acessar as funcionalidades de administrador.
   - Faça login com o **usuário comum** utilizando o email `user@gmail.com` e a senha `userpass` para testar as funcionalidades do lado do usuário.

--- 

## 👨‍💻 Desenvolvedor
- **Projeto criado por**: Luiz Fernando  
- **GitHub**: [@LuizFernando](https://github.com/Fernand0cruz)

---
