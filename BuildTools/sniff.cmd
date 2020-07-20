CD %~dp0
CD ..\SourceCode

CALL vendor\bin\phpcs -s --standard=ruleset.xml --ignore=assets/,node_modules/,vendor/,_DigitalZen/ .
