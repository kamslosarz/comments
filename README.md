Run:

`composer install --no-dev`

`php -S 127.0.0.7:8080  public/index.php`

*you may have to create `log` dir*


Hit:

`curl http://127.0.0.7:8080/comments`

`curl http://127.0.0.7:8080/comments/[0-9]+`


Tests:
`composer install`

`vendor/bin/phpunit -c tests/phpunit.xml`

