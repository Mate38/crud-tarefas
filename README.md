## Dependências

Sistema foi desenvolvido utilizando Laravel 8, PHP 7.4 e MySql 8.

## Configuração

Após clonar o projeto, com o terminal aberto na pasta do projeto, execute os comandos:

```composer install``` e ```npm install && npm run prod```

Faça duas cópias do arquivo ```.env.example``` chamadas ```.env``` e ```.env.testing```

Dentro dos arquivos ```.env``` e ```.env.testing``` edite os campos para conexão com os bancos

Exemplo:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_tarefas
DB_USERNAME=root
DB_PASSWORD=
```

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crud_tarefas_tests
DB_USERNAME=root
DB_PASSWORD=
```

Rode os comandos ```php artisan key:generate``` e ```php artisan storage:link```

Crie no MySQL os bancos "crud_tarefas" e "crud_tarefas_tests" (caso deseje utilizar outro nome modifique também no DB_DATABASE).

>Obs: O sistema possui definido como codificação de caracteres padrão o formato ```utf8mb4_unicode_ci```

Em seguida execute o comando para criação das tabelas:

```php artisan migrate```

## Autenticação

O sistema utiliza o Firebase para autenticação, assim precisamos das credenciais deste, para isso acesse o [Firebase](https://console.firebase.google.com/) e crie o projeto

Acesse o projeto > Configurações do projeto > Contas de serviço > Gerenciar permissões da conta de serviço

Crie uma conta de serviço, atentando-se para um papel com acesso para leitura/gravação

Em ações selecione Criar chave, com ```JSON``` selecionado criar

Salve o arquivo no projeto

Nos arquivos ```.env``` e ```.env.testing``` adicione o caminho para o arquivo no parâmetro ```FIREBASE_CREDENTIALS```

Exemplo

```FIREBASE_CREDENTIALS=storage/firebase/credentials/firebase_credentials.json```

## Testes

Para rodar os testes use o comando ```php artisan test```
