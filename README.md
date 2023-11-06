# Sistema de Login e Autenticação baseado em rotas

Este documento descreve o sistema de login e autenticação em uma aplicatição Laravel. 
O sistema permite que os usuários façam login, acessem recursos específicos com base em funções (roles).


## Conteúdo

1. [Introdução](#introducao)
2. [Requisitos](#requisitos)
3. [Instalação](#instalacao)
4. [Configuração](#configuracao)
5. [Registro de Usuários](#registro-de-usuarios)
6. [Login](#login)
7. [Controle de Acesso](#controle-de-acesso)
8. [Roles e Recursos](#roles-e-recursos)
9. [Personalização](#personalizacao)
10. [Referências](#referencias)

<a name="introducao"></a>
## 1. Introdução

O sistema de login e autenticação no Laravel permite que os usuários acessem o aplicativo com segurança. 
Além disso, o controle de acesso com base em funções (roles) permite que os usuários acessem apenas 
recursos específicos de acordo com suas permissões. Tudo baseado nas rotas estabelicidas dentro do meddlware acl.

Cada role pode ter muitos recursos, esses recursos sao gerados pelas rotas protegidas por middleware.
Ou podem ser cadastradas e assim usadas como verificação se acesso. O sistema permite 2 tipos de recursos:

route - Proveniente das rotas protegidas \
control - Inseridas da na tebela para controle

Cada usuário pode ter muitas roles. Quando é acessado determinada rota, e ela está protefida pelo middleware
**admin.acl** o midlleware verifica se o usuário logado pode acessar esse recurso.

Os recursos sao gerados automaticamente atravéz do comando(ResourceCommand) que pode ser invodado pela assinatura: \
_**admin:resources {roleAttach?}**_, o parametro roleAttach é o identificador da role que voce gostaria de enexar
todos os rescursos, facilinatdo assim roles do tipo admin.

Foi adicionado uma coluna em usuários **_is_root_**, essa coluna ignora as regras pemitindo que esse usuário acesse
todas as areas sem restriçao. Essa coluna é tipo unique, foi tratado hoje apenas se essa coluna contem o valor 1.
Assim atualmente nao é possivel ter mais de ums usuário root no sistema. Essa verificao utiliza a constante no model 
usuário IS_ROOT





<a name="requisitos"></a>
## 2. Requisitos

- Ambiente de desenvolvimento local ou servidor de hospedagem
- [Composer](https://getcomposer.org/) instalado
- [Node.js](https://nodejs.org/) e [NPM](https://www.npmjs.com/) instalados

<a name="instalacao"></a>
## 3. Instalação

Para instalar o aplicativo, siga os seguintes passos:

1. Clone o repositório do aplicativo.
   ```bash
   git clone https://seurepositorio.git
   ```

2. Navegue até a pasta do projeto.
   ```bash
   cd nomedopasta
   ```

3. Instale as dependências do Composer.
   ```bash
   composer install
   ```

4. Crie um arquivo `.env` a partir do arquivo `.env.example` e configure as variáveis de ambiente, incluindo a conexão com o banco de dados e a chave de criptografia do aplicativo.
   ```bash
   cp .env.example .env
   ```

5. Gere uma nova chave de aplicativo.
   ```bash
   php artisan key:generate
   ```

6. Execute as migrações para criar as tabelas do banco de dados.
   ```bash
   php artisan migrate
   ```

7. Inicie o servidor de desenvolvimento.
   ```bash
   php artisan serve
   ```

8. Acesse o aplicativo em [http://localhost:8000](http://localhost:8000).

<a name="configuracao"></a>
## 4. Configuração

O aplicativo Laravel é configurado para fornecer autenticação segura. Além disso, o sistema de controle de acesso é baseado em funções (roles) e recursos. As configurações podem ser personalizadas no arquivo `config/auth.php` e em outros lugares conforme necessário.

<a name="registro-de-usuarios"></a>
## 5. Registro de Usuários

Os usuários podem se registrar no aplicativo seguindo estas etapas:

1. Acesse a página de registro em [http://localhost:8000/register](http://localhost:8000/register).

2. Preencha o formulário de registro com as informações necessárias.

3. Clique em "Registrar" para criar uma conta de usuário.

<a name="login"></a>
## 6. Login

Os usuários podem fazer login no aplicativo seguindo estas etapas:

1. Acesse a página de login em [http://localhost:8000/login](http://localhost:8000/login).

2. Insira seu nome de usuário e senha.

3. Clique em "Login" para acessar sua conta.

<a name="controle-de-acesso"></a>
## 7. Controle de Acesso

O controle de acesso do aplicativo é baseado em funções (roles) e recursos. Cada recurso está relacionado a uma ou mais funções, e as funções estão relacionadas aos usuários. Isso garante que apenas os usuários com as permissões corretas possam acessar recursos específicos.

<a name="roles-e-recursos"></a>
## 8. Roles e Recursos

As funções (roles) e os recursos são gerenciados no aplicativo para controlar o acesso. Você pode adicionar, editar ou excluir funções e recursos conforme necessário.

<a name="personalizacao"></a>
## 9. Personalização

Você pode personalizar o sistema de autenticação, páginas de login e registro, bem como as mensagens de erro, de acordo com as necessidades específicas do seu aplicativo.

<a name="referencias"></a>
## 10. Referências

- [Documentação oficial do Laravel](https://laravel.com/docs)
- [GitHub do Laravel](https://github.com/laravel/laravel)
- [Documentação do Middleware no Laravel](https://laravel.com/docs/8.x/middleware)
- [Documentação do Controle de Acesso no Laravel](https://laravel.com/docs/8.x/authorization)

---

Esta é uma estrutura básica de documentação que você pode usar como ponto de partida. Lembre-se de personalizar e expandir a documentação de acordo com as especificidades do seu aplicativo e as necessidades da sua equipe. Certifique-se de incluir exemplos, capturas de tela e informações adicionais relevantes para facilitar o entendimento dos usuários e desenvolvedores que trabalharão com o sistema.