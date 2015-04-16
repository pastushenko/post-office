# Тестовое задание для php программиста

## Описание
В небольшом городке N есть почтовое отделение.

Каждый день в почтовое отделение поступает некоторое количество корреспонденции:
* письма (letter)
* бандероли (wrapper)
* посылки (package).

На почте работает несколько разных почтальонов:
* почтальоны-пешеходы (postman)
* почтальоны-велосипедисты (biker)
* почтальоны-водители (driver)

У почтальона-пешехода есть 3 места под письма, 1 место под бандероль и 2 места под посылки.
У почтальона-велосипедиста есть 2 места под письма, 3 места под бандероли и 1 место под посылку.
У почтальона-водителя есть 1 место под письмо, 2 места под бандероли и 3 места под посылки.

|           |  letter  |  wrapper  |  package  |
|-----------|:--------:|:---------:|----------:|
|  postman  |     3    |     1     |     2     |
|  biker    |     2    |     3     |     1     |
|  driver   |     1    |     2     |     3     |

При этом каждый почтальон (вне зависимости от типа) может за один день доставить только 3 экземпляра корреспонденции.
Почтальон не отправляется в путь, пока не наберет 3 экземпляра корреспонденции. Исключение: последний день - когда вся корреспонденция распределена
по почтальонам, осталось только доставить. Почтальон может доставлять корреспонденцию только 1 раз за день.

Есть время, за которое необходимо доставить каждый экземпляр корреспонденции. Если этого не происходит, то получатели становятся недовольными.
Уровень недовольства равняется количеству просроченных дней.

До сегодняшнего дня почта работала крайне неэффективно.

Необходимо добиться наименьшего недовольства граждан работой почтового отделения. Для этого мы тебя и позвали.

Твои задачи:
* Разобраться как работает почтовый бизнес (World.php) и почтовое отделение в небольшом городке N (PostOffice.php).
* Не меняя условия почтового бизнеса оптимизировать работу почтового отделения.
** Требуется поменять логику PostOffice.php или написать свой класс
** Запрещено изменение логики World.php
** Разрешены другие изменения с целью рефакторинга системы
* Первоначально на почте работает по одному почтальону каждого типа.
* (Не обязательное задание) Каково минимальное количество почтальонов (и каких типов) необходимо, что бы отделение почты
   отработало год с нулевым уровнем недовольства?


## Установка и запуск
Для начала работы необходимо установить все зависимости и сгенерировать класс автозагрузки.
Это делается с помощью composer (https://getcomposer.org).
    php composer.phar install

Можно запустить веб сервер
    ./script/run-server.sh

Тогда результат работы почтового отделения будет доступен по адресу http://127.0.0.1:7999

Результат выполнения имеет вид:
>Total discontent index: 131577.
>Total days: 438.

Где "Total discontent index" - индекс общего недовольства граждан работой почтового отделения,
"Total days" - количество дней, которое понадобилось чтобы доставить всю корреспонденцию.