# Test Laravel task prototype

Проект тестового задания (прототип). Отказался от DDD так как для этого
требуется больше времени (решить что использовать самописные 
репозитории или же Doctrine ORM). Репозитории в даном случаи выступаю
как абстакный уровень работы с базой данных (в моем случаи завязанны на
Eloquent ORM). В дальнейшем же планировался отказ от Eloquent ORM и добавление 
Domain Layer. Сам проект находиться в папке MyProject.
Проект выполнялся под Open Server в дальнейшем планируется перенос на Docker.

### Структура папки MyProject:

- CommonModule: храняться классы для мнгогократного использования;
- UserModule: Модуль по работе с пользователем;

### Структура UserModule модуля:
- UI: уровень представления. Храняться роуты, контроллеры и консольные команды;
- Application: уровень приложения. Расположенны комманды, запросы, сервисы
 (в них разположены обработчики команд), middleware, исключения.
- Infrastructure: уровень инфраструктуры. Хранятся модели Eloquent ORM,
 репозитории, интерфейсы, а так же миграции для создания таблиц модуля.
- Providers: храниться провайдер для модуля. 

### Стэк
- php 7.2
- MySql 5.6
- Laravel
- Eloquent ORM

### Дополнительные библиотеки
 - firebase/php-jwt (для работы с JWT);
 - joselfonseca/laravel-tactician (библиотека CommandBus);

### Перед стартом приложения добавить .env файл (изменить настройки базы данных под MySql)

### Команда для выполнения миграций для модуля UserModule:
- php artisan migrate --path=MyProject/UserModule/Infrastructure/Migrations/

### Команда для выполнения тестов:
- vendor\bin\phpunit tests\UserModule\




