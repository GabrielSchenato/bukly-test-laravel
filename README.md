## Passos para execução do projeto

Necessário ter o docker instalado na máquina [Docker](https://www.docker.com/products/docker-desktop).

Clonar o projeto em uma pasta de sua preferência:

    git clone git@github.com:GabrielSchenato/bukly-test-laravel.git

Copiar o arquivo `.env.example` para `.env` e configurar as variáveis:

    DB_HOST=mysql
    DB_DATABASE=laravel
    DB_USERNAME=sail
    DB_PASSWORD=password

Rodar o composer install:

    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs &&
    php artisan key:generate

Rodar o comando do sail para subir os containers da aplicação com o docker:

    ./vendor/bin/sail up -d

Rodar o comando para criar as tabelas do banco:

    ./vendor/bin/sail php artisan migrate

Rodar o seeder para criar os registros fakes no banco:

    ./vendor/bin/sail php artisan db:seed

Rodar o npm install para instalar as dependencias:

    ./vendor/bin/sail npm install

Rodar o npm para compilar o JS e CSS:

    ./vendor/bin/sail npm run dev

Rodar os testes para verificar que todos estão passando:

    ./vendor/bin/sail php artisan test

Acessar a aplicação e realizar os testes necessários:

    http://localhost
___


# Teste de Habilidades em Laravel

## Objetivo
Avaliar as habilidades do candidato em Laravel, compreensão e análise de requisitos, capacidade de inovação, determinação na busca de soluções e responsabilidade na tomada de decisões.

## Requisitos
1. ✅ Usar Laravel 10.x
1. ✅ Implementar um sistema simples de autenticação
1. ✅ Criar uma funcionalidade CRUD (Create / Read / Update / Delete) para duas entitades: Hotels e Rooms
1. ✅ A tabela Hotels tem os seguintes campos: name (obrigatório), address (obrigatório), city (obrigatório), state (obrigatório), zip_code (obrigatório), website
1. ✅ A tabela Rooms tem os seguintes campos: name (obrigatório), description (obrigatório), Company (foreign key)
1. ✅ Usar as migrations para criar os schemas acima
1. ✅ O endereço deve ser preenchido automaticamente via integração com a API do ViaCEP (https://viacep.com.br/).
1. ✅ Utilizar o sistema de templates Blade para renderizar as views.
1. ✅ Implementar os controllers com os métodos padrão – index, create, store etc.
1. ✅ Implementar as validações Laravel
1. ✅ Realize testes unitários para verificar a robustez do sistema
1. ✅ Documente seu código de forma clara e concisa

Bonus (opcional):

- ✅ Adicionar rotas API para ver e adicionar hotel
- ✅ Usar seeder para alimentar as tabelas hotels e rooms
- ✅ Usar Tailwind no lugar de Bootstrap

## Avaliação
O candidato será avaliado com base na implementação correta dos requisitos, a qualidade do código e a capacidade de resolução de problemas. A documentação e os testes também serão considerados na avaliação.

## Observações
- Utilize as melhores práticas do Laravel.
- Preste atenção à qualidade do código
- O projeto deve ser entregue em um repositório Git público.
