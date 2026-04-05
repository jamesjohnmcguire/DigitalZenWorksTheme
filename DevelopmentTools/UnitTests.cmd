CD %~dp0
CD ..

SourceCode\vendor\bin\phpunit --testdox --configuration Tests/phpunit.xml Tests/UnitTests.php %1 %2
