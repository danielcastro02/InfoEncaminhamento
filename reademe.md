# Documentação de isntalação

Neste arquivo estarão as instruções de intalação deste sistema

## Requisitos

- Servidor apache2 para PHP
- Banco de dados mysql >5.4 ou MariaDB >10.4
- Serviço de SMTP (Opcional)

## Instalação

- Clone este repositório para dentro da sua pasta pública do servidor
- Na raiz do projeto execute o comando: ***php composer.phar install***
- Importe o arquivo de banco de dados com a maior versão na pasta ***/Banco*** para o um banco de dados na mesma máquina do servidor apache com o nome de ***infoEncaminhamento***

## Configuração
O sistema vem com um usuário administrador cadastrado para configuração, credenciais:
Usuário: ***administrador***
Senha: ***12345678***

- Apos realizar login, na navbar lateral clique em configurações.![enter image description here](https://tcc.markeyvip.com/imagens/tcc/menu.PNG)
-Na tela de configurações, na seção de Configurações de email, defina as configurações do seu serviço de SMTP
Caso não possua serviço de SMTP, tambéem é possível desabilitar a verificação de email, porém é altamente recomendado não fazer isso.

## Recomendações

- Altamente recomendado que seja alterada a senha do usuário administrador padrão
- Recomenda-se não desativar a confirmação de e-mail
- O servidor de email e banco de dados deve estar na mesma maquina
