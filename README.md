##**Задание**

Есть три типа файлов (json, csv, xml), в которых перечислены страны и их столицы. Необходимо разработать интерфейс, с помощью которого можно было бы загружать
этот файл, выводить его содержимое на экран, редактировать и скачивать отредактированный вариант в любом из вышеперечисленных форматов.
####Основные требования:
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
   
####Критерии оценки:
1. Масштабируемость кода
2. Читабельность кода
3. *Тестируемость кода

Примеры файлов прилагаются
*Пункты со звёздочкой не обязательны

[файл архива задания](testovoe.zip)

####Deploy project
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

