<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## FSM-laravel

Несколько не обычное представление <b>fiinite state machine</b>. Но таковы были требования и текущие на тот момент условия на фронте. Не вытаскивал участки кода, которые не сам писал. Такие как сбор meta инфы (доступные url для каждого из статусов, все url для данного api). Так же не включил в пример обращения к сервисам с бизне логикой и логикой очередей в RabbitMQ. На этих местах оставли комментарии.

Все собрано под докером (стандартная сборка из документации):
<br>
<pre>docker compose -f compose.dev.yaml up -f --build </pre>

Далее <pre>docker exec -it workspace bash</pre>
<pre>cp .env.example .env</pre>
<pre>php artisan migrate</pre>
<pre>php artisan app:create-api-user</pre>
После чего в консоли отобразится токен для апи запросов (знаю что так нельзя, но это же не боевой проект)
<br>Затем можно создать накладную командой для пользователя с id = 1:
<pre>php artisan app:create-invoice 1</pre>
Немного curl для тестов:
<pre>curl --location 'localhost/api/invoices/send_to_approve/{uuid накладной}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {токен из консоли}'</pre>
<pre>curl --location 'localhost/api/invoices/approve/{uuid накладной}' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer {токен из консоли}'</pre>
<pre>curl --location 'localhost/api/invoices/reject/163c9dbc-c2a9-464d-bc5f-81df45f7ceda' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 2|Wc6SHuACcF5jS9r3nUpBb5YPPKSeKQDSaUIO48Y792f24cac'</pre>

- Готов ответить на все вопросы [@PavelV78](https://t.me/PavelV78).
