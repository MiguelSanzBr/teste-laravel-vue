# Desafio Técnico — CRM (Laravel + Inertia + Vue)

> Mini-CRM full stack com autenticação, dashboard e CRUD de colaboradores (com e-mail de boas-vindas).

## ⚠️ Importante

-   **Não altere** `Dockerfile` nem `docker-compose.*`. A homologação roda **via Docker**.
    
-   Entrega: **clone** este repositório, implemente e **envie o link do seu GitHub** via LinkedIn para **Alex Yud**: [https://www.linkedin.com/in/alexyud/](https://www.linkedin.com/in/alexyud/).

-  Use as imagens da pasta /examples como referência.

----------

## 1) Objetivo

Construir uma versão minimalista de um CRM onde a empresa acessa um painel e gerencia colaboradores.

### O que deve existir (mínimo)

**Front-end**

-   Tela de **Cadastro de Empresa** e **Login** (CNPJ + senha).
    
-   **Dashboard** com 3 cards.
    
-   Tela de **Colaboradores** com lista e botões **Criar / Editar / Remover**.
    

**Back-end**

-   Endpoints para **cadastrar empresa** e **autenticar**.
    
-   No dashboard, exibir:
    
    1.  **Colaboradores cadastrados no mês**,
        
    2.  **Demitidos no mês** (soft delete no mês),
        
    3.  **Total de colaboradores atuais** (não deletados).
        
-   CRUD de colaboradores:
    
    -   **Listar**.
        
    -   **Criar** (impedir duplicidade **por empresa**: mesmo **telefone** ou **e-mail** não pode repetir).
        
    -   **Editar**.
        
    -   **Remover** (**soft delete**).
        
-   Ao **cadastrar colaborador**, enviar **e-mail de boas-vindas**.
    

----------

## 2) Para iniciar o projeto instale

-   **PHP** 8.2+
    
-   **Node LTS**

----------

## 3) Como rodar

1.  Copie `.env.example` para `.env` no **Laravel**,  **Docker Compose** e ajuste as variáveis (DB, MAIL, APP_URL).
    
    -   Sugestão para e-mail durante o teste:
        
        `MAIL_MAILER=smtp MAIL_HOST=smtp.gmail.com MAIL_PORT=587  MAIL_USERNAME=null MAIL_PASSWORD=null MAIL_FROM_NAME="${APP_NAME}"` 
        
        _(Utilize seu email username e password para desenvolvimento.)_
        
2.  Suba o database:
    
    `docker compose up database -d --build` 
    
3.  Acesse a pasta do CRM e rode para o Laravel:
    
      `composer install` 
    `php artisan key:generate
    php artisan migrate`
     `php artisan serve`  
    
4.  Na mesma pasta do CRM abra outro terminal e rode para o Vue:
    
      `npm install`
      `npm run dev`  
    
       > http://localhost:8000.

----------

## 4) Regras de negócio

-   **Empresa**
    
    -   Cadastro com **CNPJ** (aceite máscara no front, normalize no back).
        
    -   Login por **CNPJ + senha**.
        
-   **Colaborador**
    
    -   Campos mínimos: **nome**, **telefone**, **e-mail**.
        
    -   **Unicidade por empresa**:
        
        -   (`company_id`, `phone`) **único**.
            
        -   (`company_id`, `email`) **único**.
            
        
        > Garanta isso via **validação** e **índices únicos** no banco.
        
    -   **Remoção**: **soft delete** (ex.: `deleted_at`).
        
    -   **E-mail de boas-vindas** disparado **após criar**.
        
-   **Dashboard**
    
    -   **Cadastrados no mês**: `created_at` dentro do mês corrente (e não deletados).
        
    -   **Demitidos no mês**: _soft-deleted_ com `deleted_at` no mês corrente.
        
    -   **Total atuais**: colaboradores **não deletados** da empresa.
        

----------

## 5) O que esperamos

-   Tudo **funcionando** de ponta a ponta (login → dashboard → CRUD + e-mail).
    
-   **Código limpo**, componentes Vue organizados, controllers/services coesos.
    
-   **Migrations** e **seeders** quando fizer sentido.
    
-   **Validações robustas** (back-end é a fonte da verdade).
    
-   **Mensagens de erro** claras no front.
    
-   **UX simples** (loading/disabled, feedback de sucesso/erro).
    
-   **Commit messages** descritivas.
    
-   **README atualizado** (se alterar algo relevante).
    

----------

## 6) Critérios de avaliação

1.  **Correção funcional** (atende todos os requisitos mínimos).
    
2.  **Qualidade do código** (organização, padrões, SOLID onde couber, separação de camadas).
    
3.  **Modelagem de dados** (chaves/índices, unicidade por empresa, soft delete).
    
4.  **Experiência do usuário** (fluxo claro, feedbacks, acessibilidade básica).
    
5.  **Boas práticas Laravel/Vue** (validação, policies/middlewares, componentes).
    
6.  **E-mail de boas-vindas** (conteúdo, envio confiável).
    
7.  **Git** (histórico legível).
    

----------

## 7) Extras (opcionais — contam pontos)
    
-   Paginação/busca/ordenação na listagem.
    
-   Policies/guards multi-empresa.
    
-   Estados de loading e toasts bonitinhos no front.

-	Recuperação de senha

-	Editar dados da empresa
    
----------

**Boa sorte!** Qualquer inconsistência que impeça rodar em Docker, documente no README do seu fork.
