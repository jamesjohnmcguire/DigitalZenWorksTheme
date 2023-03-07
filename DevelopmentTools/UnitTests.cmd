CD %~dp0
CD ..

SourceCode\vendor\bin\phpunit --testdox -c Tests/phpunit.xml Tests/UnitTests.php %1 %2
