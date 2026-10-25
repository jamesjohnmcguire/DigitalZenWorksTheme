CD %~dp0
CD ..

php vendor\bin\phpunit --configuration Tests/phpunit.xml %*
