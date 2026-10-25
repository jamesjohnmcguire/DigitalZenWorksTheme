@ECHO OFF
SETLOCAL

PUSHD "%~dp0.." || EXIT /B 1

CALL DevelopmentTools\Common\Commands\composerStatus.cmd
IF ERRORLEVEL 1 GOTO failed

CALL DevelopmentTools\Common\Commands\npmStatus.cmd
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Checking JavaScript...
CALL npx eslint DevelopmentTools/minify.js
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Minifying assets...
CALL node DevelopmentTools/minify.js
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Creating language files
CALL wp i18n make-pot SourceCode SourceCode/languages/digitalzen.pot
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Checking syntax...
CALL vendor\bin\parallel-lint.bat --exclude .git --exclude vendor .
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Code Analysis...
CALL vendor\bin\phpstan.phar.bat analyse
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Checking code styles...
CALL vendor\bin\phpcs.bat -sp --standard=ruleset.xml SourceCode
IF ERRORLEVEL 1 GOTO failed

ECHO .
CALL vendor\bin\phpcs.bat -sp --standard=ruleset.tests.xml Tests
IF ERRORLEVEL 1 GOTO failed

ECHO .
ECHO Running Automated Tests
CALL vendor\bin\phpunit.bat --configuration Tests\phpunit.xml
IF ERRORLEVEL 1 GOTO failed

POPD
EXIT /B 0

:failed
SET "exitCode=%ERRORLEVEL%"
POPD
EXIT /B %exitCode%
