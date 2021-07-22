CD %~dp0
CD ..\..

CALL composer outdated
CALL composer install

IF EXIST vendor.bak\NUL RD /S /Q vendor.bak
IF EXIST vendor.export\NUL RD /S /Q vendor.export

ECHO Backing up vendor
XCOPY /C /D /E /H /I /R /S /Y vendor vendor.bak >NUL

ECHO Installing vendor no dev
CALL composer install --no-dev

CD vendor

DEL /S /Q *.md >NUL
CD ..

REN vendor vendor.export
REN vendor.bak vendor
