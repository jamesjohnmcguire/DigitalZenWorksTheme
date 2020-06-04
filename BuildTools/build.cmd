cd %DigitalZenThemePath%
cd SourceCode

IF "%1"=="complete" GOTO complete
GOTO update

:complete
CALL composer install
ECHO outdated:
CALL composer outdated

ECHO Code analysis:
CALL vendor\bin\phpcs -s --standard=ruleset.xml --ignore=vendor/ .

REM CALL vendor\bin\phpunit -c UnitTests\phpunit.xml --bootstrap .\includes\autoload.php UnitTests\UnitTests.php

:update
PAUSE update
CALL grunt sass
CALL grunt cssmin
CALL grunt uglify
REM CALL grunt watch

:deploy
REM Remove all development only packages, as this is going out into the wild
CALL composer install --no-dev

REM Replace all version tags with latest version tag from GIT
FOR /F "tokens=* USEBACKQ" %%g IN (`git describe --tags --abbrev^=0`) do (SET "GIT_VERSION_TAG=%%g")
SED -i "s|[[:digit:]]\+\.[[:digit:]]\+\.[[:digit:]]\+|%GIT_VERSION_TAG%|g" style.css

7z u DigitalZenTheme.zip . -xr!.editorconfig -xr!node_modules -xr!UnitTests
move /Y DigitalZenTheme.zip ..
