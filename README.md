# TestePraticoPHPLaravel


Instruções para acessar a API no localhost http://127.0.0.1:8000/api/consulta-ofertas

Foi instalado:
PHP Version: PHP 8.2.6 (cli) (built: May 9 2023 16:02:16) (ZTS Visual C++ 2019 x64) Copyright (c) The PHP Group Zend Engine v4.2.6, Copyright (c) Zend Technologies

Laravel Version: Laravel Framework 10.11.0

Laragon Version: Laragon Full 6.0

MySQL Server Version: Server version: 8.0.33 MySQL Community Server - GPL

App Postman:

Foi creado um projeto novo no Visual Studio Code laravel/laravel

Foi criada uma conexão com o banco de dados. Informação para conectar com o banco de dados está no arquivo ".env"

Foi criada uma rota nova no "api.php" Codigo no arquivo "api.php"

Foi instalado a dependencia Guzzle package: composer require guzzlehttp/guzzle

Foi criado um Controller chamado "ApiController.php" Codigo no arquivo "ApiController.php"

Foi criado um Model chamado "Registro.php" Tanto o Model quanto a Migration foram criadas usando o comando "php artisan make:model Registro -m" Codigo no arquivo "Registro.php"

Foi criado um Migration chamado "2023_05_22_113020_create_registros_table.php" para rigistrar o returno da API. A migração foi rodada usando o comando "php artisan migrate" Codigo no arquivo "2023_05_22_113020_create_registros_table.php"

O servidor local foi iniciado usando Laragon.

O projeto foi iniciado no Visual Studio Code usando o comando "php artisan serve".

Testes foram feitos no App Postman usando o Endpoint "http://127.0.0.1:8000/api/consulta-ofertas" Parametro utilizado foi "cpf", valores usados: 11111111111, 12312312312, 22222222222, 11111111110.
