## **Задание**

Есть три типа файлов (json, csv, xml), в которых перечислены страны и их столицы. Необходимо разработать интерфейс, с помощью которого можно было бы загружать
этот файл, выводить его содержимое на экран, редактировать и скачивать отредактированный вариант в любом из вышеперечисленных форматов.
#### Основные требования:
1. Главная страница содержит форму загрузки файлов
2. После успешной загрузки отображается интерфейс редактирования списка, который позволяет:
   - а. Добавлять данные
   - б. Изменять данные
   - в. Удалять данные
3. На странице редактирования находится кнопка "скачать" и выбор формата для скачивания в виде дропдауна с вариантами (json, csv, xml)
4. Известно, что вскоре будут добавлены новые форматы данных, однако нет информации какие именно
5. В качестве инструментов используем Laravel и Vue.js/jquery/js
6. *Написать Unit тесты
7. *Написать консольную команду, которая будет конвертировать списки из одного формата в другой.
Например "php artisan convert:countries --input-file=countries.xml --output-file=countries.json"
   
#### Критерии оценки:
1. Масштабируемость кода
2. Читабельность кода
3. *Тестируемость кода

Примеры файлов прилагаются
*Пункты со звёздочкой не обязательны

[файл архива задания](testovoe.zip)

#### Deploy project
Go to working directory

0. ```git clone https://github.com/skrypnik-dzencode/tt_ccfiles.git .```
1. ```composer install```
2. ```cp .env.example .env```
3. ```vim .env``` to setup environment
4. ```php artisan key:generate```
5. ```npm i && npm run dev```
6. ```php artisan storage:link```

##### artisan commands
- ```php artisan test``` to run tests
- ```php artisan list | grep convert``` to show convert commands
- ```php artisan convert:countries --input-file=countries.json --output-file=countries.xml``` convert command (inline way)
- ```php artisan convert:countries -I countries.json -O countries.xml``` convert command with shortcuts (inline way)
- ```php artisan convert:countries-i``` convert command via interactive mode


### *Also you can use docker-compose**
#### Deploy project with docker**
Go to working directory

0. ```git clone https://github.com/skrypnik-dzencode/tt_ccfiles.git .```
1. ```cd docker```
2. ```docker-compose up -d --build```
3. ```docker-compose run --rm composer install```
4. ```cp ../.env.example ../.env```
5. ```vim ../.env``` to setup environment
6. ```docker-compose run --rm fpm php artisan key:generate```
7. ```docker-compose run --rm npm install```
8. ```docker-compose run --rm npm run dev```
9. ```docker-compose run --rm fpm php artisan storage:link```

##### artisan commands
- ```docker-compose run --rm fpm php artisan test``` to run tests
- ```docker-compose run --rm fpm php artisan list | grep convert``` to show convert commands
- ```docker-compose run --rm fpm php artisan convert:countries --input-file=countries.json --output-file=countries.xml``` convert command (inline way)
- ```docker-compose run --rm fpm php artisan convert:countries -I countries.json -O countries.xml``` convert command with shortcuts (inline way)
- ```docker-compose run --rm fpm php artisan convert:countries-i``` convert command via interactive mode

*Install docker-compose first

**It is a draft version for this project
