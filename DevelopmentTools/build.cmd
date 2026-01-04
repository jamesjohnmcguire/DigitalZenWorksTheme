CD %~dp0
CD ..

ECHO Checking composer...
CALL composer install --prefer-dist
CALL composer validate --strict
ECHO outdated:
CALL composer outdated --direct

ECHO Checking npm...
CALL npm install
CALL npm outdated

ECHO Checking PHP code styles
CALL vendor\bin\phpcs -sp --standard=ruleset.xml SourceCode

IF "%2"=="update" GOTO update
GOTO continue

:update
ECHO Updating version
CALL VersionUpdate style.css
CALL VersionUpdate style-rtl.css
CALL VersionUpdate functions.php

SET BootStrapVersion=5.3.5
wget https://github.com/twbs/bootstrap/releases/download/v%BootStrapVersion%/bootstrap-%BootStrapVersion%-dist.zip

7z x bootstrap-%BootStrapVersion%-dist.zip -o..\SourceCode\assets\Bootstrap\ -y >NUL 2>NUL

MOVE /Y bootstrap-%BootStrapVersion%-dist\css\bootstrap.min.css assets\css\vendor
MOVE /Y bootstrap-%BootStrapVersion%-dist\css\bootstrap.min.css.map assets\css\vendor
MOVE /Y bootstrap-%BootStrapVersion%-dist\js\bootstrap.bundle.min.js assets\js\vendor
MOVE /Y bootstrap-%BootStrapVersion%-dist\js\bootstrap.bundle.min.js.map assets\js\vendor

:continue
ECHO Creating language files
CALL wp i18n make-pot . languages/digitalzen.pot

ECHO ON
CALL grunt cssmin

vendor\bin\phpunit --testdox -c Tests/phpunit.xml Tests/UnitTests.php %1 %2

IF "%1"=="deploy" GOTO deploy
GOTO finish

:deploy
CD SourceCode
IF EXIST vendor.bak\NUL RD /S /Q vendor.bak
IF EXIST vendor.export\NUL RD /S /Q vendor.export

ECHO Backing up vendor
XCOPY /C /D /E /H /I /R /S /Y vendor vendor.bak >NUL

ECHO Installing vendor no dev
CALL composer install --no-dev --prefer-dist

CD vendor

DEL /S /Q *.md >NUL 2>NUL
CD ..

IF EXIST DigitalZenTheme.zip DEL /Q DigitalZenTheme.zip

7z a DigitalZenTheme.zip . -xr!.editorconfig -xr!.eslintrc -xr!.stylelintrc.json -xr!composer.* -xr!Gruntfile.js -xr!package.* -xr!package-lock.* -xr!ruleset.xml -xr!DevelopmentTools -x!node_modules -x!vendor.bak

REN vendor vendor.export
REN vendor.bak vendor

:finish
