<details>
  <summary>Українською</summary>

## **Завдання**

Є три типи файлів: json, csv, xml, зміст яких - країни та столиці. Необхіднео розробити інтерфейс, за допомогою якого можливо завантажити один із файлів,
вивести його зміст на екран, редагувати і викачати змінений варіант у будьякому із зазначених форматів.
#### Основні вимоги:
1. Головна сторінка має форму загрузки файлів
2. Після завантаження зʼявляється інтерфейс редагування списку, що дозволяє:
    - а. Додавати дані
    - б. Змінбвати дані
    - в. Видаляти дані
3. На сторінці знаходиться кнопка "download" і вибор формату файлу у вигляді дропдауну з варіантами: json, csv, xml
4. Відомо, що незабаром будуть додані нові формати, але нема інформації які саме
5. Використовувати Laravel і Vue.js / jquery / js
6. *Додати Unit тести
7. *Додати консольну команду, що буде конвертувати списки з одного формату в інший.
   Наприклад "php artisan convert:countries --input-file=countries.xml --output-file=countries.json"

#### Критерії оцінки:
1. Можливість масштабування коду
2. Читабельність коду
3. *Тестування коду

Приклади файлів додаються<br>
*Пункти із зірочкою не обовʼязкові

[файли архіву завдання](testovoe.zip)
</details>

<details>
  <summary>English</summary>

## **Test task**

There are three types of files: json, csv, xml with list of countries and capitals. You need to develop an interface to upload one of the files,
display its content on the screen, edit and download the modified version in any of the specified formats.
#### Requirements:
1. Main page has a form to upload the file
2. After uploading, the interface for editing the list appears. It allows you to:
    - а. Add data
    - б. Change data
    - в. Delete data
3. There is a "download" button on the page and a dropdown to choosing the file format: json, csv, xml
4. It is known that new formats will be added soon, but there is no information about which ones
5. You should to use Laravel and Vue.js / jquery / js
6. *Unit tests
7. *Console command to convert format from one to another.
   Example "php artisan convert:countries --input-file=countries.xml --output-file=countries.json"

#### Evaluation criteria:
1. Scalability
2. Readability
3. *Testability

Example files are attached<br>
*Points with an asterisk are optional

[task archive files](testovoe.zip)
</details>

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
