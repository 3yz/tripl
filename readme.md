Tripl v0.2
================

Kohana + HTML5Boilerplate + SASS + lot of "living on the edge" web technologies stuffs

Instalação 
----------

Primeiro, clone o tripl:

    git clone https://github.com/3yz/tripl.git nome_do_projeto

Depois de clonar, você deve iniciar os módulos:

    git submodule update --init

Ele irá instalar os módulos necessários para o funcionamento.

Deployment
----------

**1º passo**

Acessar a URL do projeto e verificar se o servidor tem todos os requisitos necessários para rodar o sistema. Se tudo estiver ok, remova o arquivo install.php da raiz.

**2º passo** 

Renomeie os arquivos:

- example.htaccess -> .htaccess
- application/example.bootstrap.php -> application/bootstrap.php

**3º passo**

No fim do arquivo .htaccess (que se encontra na raiz do pacote), deve ser alterado as seguintes variáveis:

- SetEnv KOHANA_ENV PRODUCTION 
- RewriteBase / 

o KOHANA_ENV deve estar em configurado para PRODUCTION e o RewriteBase deve ser configurado com o caminho do site no server. Se por exemplo o site for www.sitedeexemplo.com.br, o Rewrit
eBase deve ser /. Caso for www.sitedeexemplo.com.br/homologacao o RewriteBase deve ser /homologacao/;

**4º passo**

Alterar o arquivo application/bootstrap.php, colocar na variável $base_url o mesmo caminho colocado no RewriteBase;

**5º passo**

Configurar o banco de dados, colocar os dados para acessar a base no arquivo application/config/database.php de acordo com o ambiente que vocês estiver. 
