# Gerenciador de gatos

Aplicação que tem como objetivo realizar um crud utilizando uma API em  PHP e uma view que consome essa API em Vue.

## Instalação
1 - Configure um servidor para rodar a aplicação.
##
2 - Estamos utilizando uma base SQL para rodar a aplicação então vá até o arquivo /config/db.sql e criar a sua base de dados.
##
3 - Va até controllers/Cats.php e altere os dados de conexão com o banco de dados.
```php
 $this->PDO = new \PDO('mysql:host=SEUHOST;dbname=SEUDB', 'SEULOGIN', 'SUASENHA'); 
```
##

Rode o comando abaixo
```bash
composer install
```

## Utilização
A utilização é bastante simples as ações de crud estão logo na página inicial do projeto, la se pode adicionar, editar ou excluir um "gato", além de poder ver todos que estão cadastrados na base de dados.
##
No caminho api/index.php  temos os metodos que a API ele está utilizando 

1 -  api/GET para pegar todos os dados da base de dados.
##
2 -  api/GET/id para pegar um dado especifico.
##
3 - api/POST para fazer um novo cadastro
##
4 - api/PATCH/id para atualizar um cadastro
##
5 api/DELETE/id para deletar um registro da base de dados 

## Licença
[MIT](https://choosealicense.com/licenses/mit/)