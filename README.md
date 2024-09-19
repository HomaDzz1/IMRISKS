
# Утилита IMRISKS v1.0

## Имитационное моделирование рисков информационной безопасности

Программное обеспечение предоставляющее возможность создать имитационную модель и стратегию обработки рисков информационной безопасности на основе исходных данных об их параметрах.

Решения сторонних авторов что использовались для разработки программного обеспечения, а так же используются для его работы:
- [jQuery v3.7.1](https://jquery.com), для обеспечения быстрого взаимодействия с утилитой за счет технологии AJAX;
- [SimpleXLSX](https://github.com/shuchkin/simplexlsx), для функционала импорта документов в формате XLSX  - автор [Сергей Щучкин](https://github.com/shuchkin);
- [AnyChart](https://www.anychart.com/), для функционала графического представления созданной модели и стратегии обработки рисков.

# [Требования для запуска утилиты и работы с ней]

Программное обеспечение является веб-приложением и требует предварительного развертывания определенной среды для использования (веб-сервера). В качестве среды можно использовать:

- полноценную выделенную систему (Windows\Unix) на физической или виртуальной машине;
- приложения имитирующие локальный веб-сервер, такие как: OsPanel 6 (использовался для разработки), Open Server, DENWER и иные.

Для доступа со стороны пользователя требуется иметь сетевой доступ к среде размещения утилиты. Обращаться к среде (по назначенному ей адресу) для взаимодействия с утилитой необходимо с использованием одного из следующих поддерживаемых интернет браузеров:

- Google Chrome (приоритетный вариант);
- Mozilla Firefox;
- Microsoft Edge.

Вне зависимости от формата выбранной среды она должна включать в себя следующие компоненты для работы:
- Веб-сервер (например, Apache);
- PHP 8.3;
- Модуль SQLITE для PHP.

# [Развертывание среды]

**Инструкция для Windows**

Шаг 1. Установка веб-сервера:

0. Отключить все иные веб-сервера если таковые присутствуют (например, может быть включен IIS).

1. Необходимо скачать веб-сервер Apache. Дистрибутив доступен [здесь](https://www.apachelounge.com/download/).

2. Разместить его в корне локального диска, чтобы итоговый путь получился: **"C:\Apache24"**. Если путь будет выбран иной следует учитывать что дальнейште команды следует вводить с тем путем, что был выбран самостоятельно.

3. Открыть настроечный файл Apache по пути: **"C:\Apache24\conf\httpd.conf"**.

4. Установить путь размещения Apache что выбрали в пункте 2 для параметра **Define SRVROOT** (его можно найти по поиску в файле). Значение должно быть: **Define SRVROOT "c:/Apache24"**. В пути обязательно должен использоваться правый символ слэша (/).

5. Установить Apache в качестве службы. Для этого открыть командную строку (CMD) от имени администратора и ввести команду **C:\Apache24\bin\httpd.exe -k install**. Для деинсталляции использовать с ключом **uninstall**, вместо **install**.

6. Если система запросит разрешение для приложения пользоваться сетевым соединением - выбрать вариант **Разрешить**.

7. Для запуска службы открыть меню пуск и запустить программу **services.msc**, где найти и выбрать службу **Apache2.4**, после чего нажать кнопку **Запустить**. Если тип запуска в окне службы установлен отличный от **Автоматически**, то служба при следующем запуске системы самостоятельно включаться не будет и ручной запуск придется повторять таким образом каждый раз при необходимости.

8. Убедиться что веб-сервер Apache был запущен. Для этого в браузере в адресной строке ввести **localhost** или **127.0.0.1**. В окне должна будет появиться фраза **"It works!"**, что означает успешность установки и настройки веб сервера.

Шаг 2. Установка PHP 8.3 и включение модуля SQLITE

0. Необходимо скачать PHP 8.3. Дистрибутив доступен [здесь](https://windows.php.net/download#php-8.3). Выбирать вариант **Thread Safe**.
1. Распаковать загруженный дистрибутив в корень локального диска, чтобы итоговый путь к нему получился **"C:\PHP"**.
2. Открыть командную строку (CMD) от имени администратора и ввести туда команду **rundll32 sysdm.cpl,EditEnvironmentVariables**.
3. В открывшемся окне в нижней части в списке **Системные переменные** выбрать переменную **Path** и нажать кнопку **Изменить**.
4. Далее нажать кнопку **Создать** и ввести путь размещения извлеченного дистрибутива PHP из пункта 1, после чего добавление подтвердить, а окно закрыть.
5. настроить PHP ддля работы с Apache. Открыть настроечный файл Apache по пути **C:\Apache24\conf\httpd.conf**. Добавить в него следующие строки (в начало или конец файла). Если самостоятельно при установке менялся путь на какой-либо друго из инструкции - тут его следует поменять, учитывая что должен использоваться символ правый слэш (/):

> - PHPIniDir "C:/PHP"
> - LoadModule php_module "C:/PHP/php8apache2_4.dll"
> - AddType application/x-httpd-php .php
> - DirectoryIndex index.php index.html

6. Перейти в папку с PHP (C:/PHP), найти в ней файл **php.ini-production**, сделать его копию в ту же самую папку, но так, чтобы имя файла осталось **php.ini** (то есть, убрать из расширения **"-production"**).
7. В созданном файле найти строки **;extension=sqlite3** и **;extension=pdo_sqlite**, убрать перед ними символ точки с запятой (;), после чего файл сохранить и закрыть.
8. Перезапустить службу Apache (делается аналогично включению, только с нажатием перед этим кнопки **Остановить**, а затем **Запустить**).

Шаг 3. Размещение утилиты на веб-сервере и проверка результатов настройки

1. Скачать актуальные файлы утилиты с настоящей страницы (**Code** -> **Download Zip**).
2. Извлечь файлы из скачанного архива по пути **C:\Apache24\htdocs** (или по иному пути, если менялся в ходе настройки, но именно в папку **htdocs**).
3. Открыть в одном из предложенных браузеров адрес **localhost** или **127.0.0.1**. Должна открыться страница утилиты с выбором проектов для работы.
4. На этом развертывание **завершено**.
