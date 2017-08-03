# Cinema Park API
PHP библиотека для интеграции с информационными системами Синема Парк.

[![Latest Stable Version](https://poser.pugx.org/axp-dev/cinemapark-api/v/stable)](https://packagist.org/packages/axp-dev/cinemapark-api)
[![Latest Unstable Version](https://poser.pugx.org/axp-dev/cinemapark-api/v/unstable)](https://packagist.org/packages/axp-dev/cinemapark-api)
[![License](https://poser.pugx.org/axp-dev/cinemapark-api/license)](https://packagist.org/packages/axp-dev/cinemapark-api)

## Оглавление
1. [Старт](#Старт)
    + [Composer](#Установка-через-composer)
    + [Инициализация](#Инициализация)
2. [Использование](#Использование)
    + Получение информации по кинотеатрам, фильмам и сеансам
        + [Получение списка мультиплексов и городов](#Получение-списка-мультиплексов-и-городов)
        + [Получение списка фильмов](#Получение-списка-фильмов)
        + [Привязка фильмов к мультиплексам](###Привязка-фильмов-к-мультиплексам)
        + [Получение расписания фильма](#Получение-расписания-фильма)
        + [Получение расписания мультиплекса](#Получение-расписания-мультиплекса)
        + [Получение дополнительной информации по фильму](#Получение-дополнительной-информации-по-фильму)
        + [Получение списка залов по всем мультиплексам](#Получение-списка-залов-по-всем-мультиплексам)
        + [Получение списка форматов показа фильмов](#Получение-списка-форматов-показа-фильмов)
        + [Комплексная выгрузка текущего расписания мультиплекса](#Комплексная-выгрузка-текущего-расписания-мультиплекса)
    + ~~Организация интернет-бронирования и продаж~~
3. [Автор](#Автор)
4. [Лицензия](#Лицензия)

## Старт
### Установка через composer
```
$ composer require axp-dev/cinemapark-api
```
### Инициализация
```php
$CinemaPark = new AXP\CinemaPark\CinemaPark();

// Получаем информаицю по фильму "Гадкий я 3"
$film = $CinemaPark->getFilmInfo(3679);
```

## Использование
### Получение списка мультиплексов и городов
```php
public function getMultiplexes() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
id | integer | Идентификатор мультиплекса
short_name | string | Короткое название мультиплекса
full_name | string | Полное название мультиплекса
description | string | Описание кинотеатра
phone | string | Телефон кинотеатра
formats | array | Список форматов показа фильмов
city_id | integer | Идентификатор города мультиплекса
city_name | string | Наименование города мультиплекса
address | string | Адес мультиплекса
multiplex_geo | string | Географические координаты мультиплекса

### Получение списка фильмов
В список могут попадать фильмы, не значащиеся в расписании мультиплексов (к примеру, поставленные в прокат на будущее, но без конкретного расписания).
```php
public function getFilms() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
has_subtitles | bool | Если фильм идёт с субтитрами (скорее всего, с оригинальной звуковой дорожкой)
age_id | integer | Код возрастных ограничений
startdate | string | Дата старта проката в нашей сети (без учёта возможных премьерных показов)
genre | string | Текстовое описание жанра фильма
original_title | string | Оригинальное название фильма (для иностранных фильмов)
timing | integer | Продолжительность фильма в минутах
age_limit | integer | Возрастное ограничение. В будущем будет произведён полный переход от age_id к age_limit
category | string | Slug категории 
title | string | Русскоязычное название фильма с учётом формата
film_id | integer | Идентификатор фильма
youtubeid | string | Список трейлеров с Youtube (через запятую) 

### Привязка фильмов к мультиплексам
В список могут попадать фильмы, не значащиеся в расписании мультиплексов (к примеру, поставленные в прокат на будущее, но без конкретного расписания).
```php
public function getFilmsMultiplexes() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма
multiplex | array | Идентификатор мультиплекса, к которому привязан фильм

### Получение расписания фильма
Выводится всё известное расписание, в т.ч. и прошедшие сеансы.
```php
public function getRepertoir($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
format_id | integer | Идентификатор формата показа, соответствующий выгрузке formats
hall | integer | Идентификатор зала (уникален для всей сети)
base_price | integer | Цена билета на сеанс без учёта скидок (в российских рублях)
id | integer | Идентификатор сеанса
state | bool | Состояние сеанса (открыт, либо фильмокопия не поступила / произошёл срыв сеанса / сеанс отменён)
datetime | string | Дата/время сеанса (местное время соответствующего мультиплекса)
multiplex | integer | Идентификатор мультиплекса
glasses_price | integer | Дополнительная стоимость, взимаемая на кассе за 3D-очки

### Получение расписания мультиплекса
```php
public function getMultiplexRepertoir($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор мультиплекса
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
format_id | integer | Идентификатор формата показа, соответствующий выгрузке formats
hall | integer | Идентификатор зала (уникален для всей сети)
base_price | integer | Цена билета на сеанс без учёта скидок (в российских рублях)
id | integer | Идентификатор сеанса
state | bool | Состояние сеанса (открыт, либо фильмокопия не поступила / произошёл срыв сеанса / сеанс отменён)
datetime | string | Дата/время сеанса (местное время соответствующего мультиплекса)
multiplex | integer | Идентификатор мультиплекса
glasses_price | integer | Дополнительная стоимость, взимаемая на кассе за 3D-очки

### Получение дополнительной информации по фильму
```php
public function getFilmInfo($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор фильма

#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
hit | bool | Присвоен ли фильму статус «Хит»
description | string | Описание фильма
addinfo | array | Дополнительная информация, тип которой указан в атрибуте «title» (режиссёр, актёры, озвучка)
year | integer | Год выпуска фильма
country | string | Страна фильма

### Получение списка залов по всем мультиплексам
```php
public function getHalls() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
multiplex_id | integer | Идентификатор мультиплекса
title | string | Идентификатор зала внутри мультиплекса
id | integer | Идентификатор зала внутри мультиплекса

### Получение списка форматов показа фильмов
```php
public function getFormats() : array
```
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
id | integer | Идентификатор формата (показываемый в выгрузке repertoir как format_id)
short_name | string | Наименование формата
title_suffix | sting | Текстовая строка, которую нужно добавить к названию фильма, чтобы получить «название фильма с учётом формата»
priority | integer | Очерёдность показа формата в списке форматов

### Комплексная выгрузка текущего расписания мультиплекса
```php
public function getTimeTable($id) : array
```
#### Параметры метода
Название | Тип | Описание
-----|-----|---------
id | integer | Идентификатор мультиплекса
#### Результат ответа
Поле | Тип | Описание
-----|-----|---------
hall | integer | Идентификатор зала (уникален для всей сети)
hall_title | string | Маркетинговое/коммерческое наименование зала
datetime | string | Дата/время сеанса (местное время соответствующего мультиплекса)
base_price | integer | Цена билета на сеанс без учёта скидок (в российских рублях)
age_limit | integer | Возрастное ограничение на фильм
title | string | Название фильма с учётом формата
hall_website_id | integer | Идентификатор зала на сайте СИНЕМА ПАРК
has_subtitles | bool | Наличие субтитров на сеансе

## Автор
[Alexander Pushkarev](https://github.com/axp-dev), e-mail: [axp-dev@yandex.com](mailto:axp-dev@yandex.com)

## Лицензия
Основой Cinema Park API являет открытый исходный код, в соответствии [MIT license](https://opensource.org/licenses/MIT)