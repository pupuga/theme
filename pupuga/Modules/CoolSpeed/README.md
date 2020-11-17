CoolSpeed Module
==================================================

**Модуль помогает поднять points в [Google PageSpeed](https://developers.google.com/speed/pagespeed/insights/)**  


Install
-------
* Переписать или clone репозиторий `pupuga` в свою Wordpress тему и подключить файл `/pupuga/Init.php`. 
* В файле `/pupuga/Config.php` убедиться, что данный модуль подключен  
```php
$config = array(
        ...
        'modules' => array(
            ...
            'CoolSpeed',
            ...
        ),
        ...
    );
```

Default config
--------------
Ниже приведен `default config`, который нужно перенастроить под свой проект
```php
$config = array(
    ...
    'mode' => array (
        'dev' => false,
        'exclude' => false,
        'encoding' => false
    ),
    'post-type' => array('page', 'banks', 'relevanter-artikler'),
    'parse' => array (
        'script' => array(
            'file' => array('tag' => 'script', 'source' => 'src', 'ext' => array('js'), 'path' => true),
            'dev' => array(
                'themes/forbruslan-test/pupuga/assets/dist/main.js'
            )
        ),
        'style' => array(
            'file' => array('tag' => 'link', 'source' => 'href', 'ext' => array('css'), 'path' => true),
            'dev' => array(
                'themes/forbruslan-test/pupuga/assets/dist/main.css'
            ),
            'path' => array(
                '/plugins/contact-form-7/' => array('../../' => 2),
            )
        ),
        'img' => array(
            'file' => array('tag' => 'img', 'source' => 'src', 'ext' => array('jpg', 'png', 'svg'), 'path' => false),
        )
    ),
    'header' => array(
        'fonts' => array(
            'https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2',
            'https://fonts.gstatic.com/s/sourcesanspro/v12/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu.woff2',
            'https://fonts.gstatic.com/s/sourcesanspro/v12/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdu.woff2'
        ),
        'resources' => array(
            'https://connect.facebook.net',
            'https://www.google-analytics.com'
        )
    )
)
```

`'mode'` parameter (array)
-----------------------
* Режим разработки (true || false)
```php
'dev' => false,
```
* Подключать или нет файлы внутрь в режиме разработки (true || false)
```php
'exclude' => false,
```
* Форсировать или нет кодировку `utf-8` (true || false). При включенном режиме большая нагрузка.
```php
'encoding' => false
```

`'post-type'` parameter (array)
----------------------------
Массив `post-type`, на которых будет работать данный модуль

```php
'post-type' => array('page', 'post'),
```

`'parse'` parameter (array => 'script', 'style')
------------------------
Массив настроек какие ресурсы и как обрабатывать.  
#### Файлы скриптов `'script'`
* Настройка обработки файлов `'file'` (array). Рекомендуется оставить по-умолчанию.
```php
'file' => array('tag' => 'script', 'source' => 'src', 'ext' => array('js'), 'path' => true),
```
* Какие файлы не подключать в dev mode `'dev'` (array). Указать файл с частью пути к нему (работает как маска)
```php
'dev' => array(
    'themes/forbruslan-test/pupuga/assets/dist/main.js'
)
```
#### Файлы стилей `'style'`
* Настройка обработки файлов `'file'` (array). Рекомендуется оставить по-умолчанию.
```php
'file' => array('tag' => 'link', 'source' => 'href', 'ext' => array('css'), 'path' => true),
```
* Какие файлы не подключать в dev mode `'dev'` (array). Также для данных файлов полностью отключается minimize. Указать файл с частью пути к нему (работает как маска)
```php
'dev' => array(
    'themes/forbruslan-test/pupuga/assets/dist/main.css'
),
```
* Корректировка путей ресурсов внутри файлов стилей `'path'` (array).  
**Key** - маска файла стилей.  
**Value** - массив, в котором **Key** - что заменять, **Value** - цифра, указывающая на сколько папок ограничить `url`, 
который будет добавлен к ресурсу вместо **Key**, данного массива
```php
'path' => array(
    '/plugins/contact-form-7/' => array('../../' => 2),
)
```

`'header'` parameter
--------------------
Данные ресурсы будут подключены в тег `<head>`
* Загрузка woff2 шрифтов, которые "не понравились" Google - `'fonts'` (array).
```php
'fonts' => array(
    'https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v12/6xKydSBYKcSV-LCoeQqfX1RYOo3ig4vwlxdu.woff2',
    'https://fonts.gstatic.com/s/sourcesanspro/v12/6xKydSBYKcSV-LCoeQqfX1RYOo3i54rwlxdu.woff2'
),
```
* Подключение ресурсов, которые "не понравились" Google - `'resources'` (array).
```php
'resources' => array(
    'https://connect.facebook.net',
    'https://www.google-analytics.com'
)
```
#### P.S. Рекомендуется также установить плагин [a3-lazy-load](https://wordpress.org/plugins/a3-lazy-load/)