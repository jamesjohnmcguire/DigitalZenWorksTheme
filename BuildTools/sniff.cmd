CALL GawaBase.cmd

cd SourceCode\Server\Web

REM CALL vendor\bin\phpcs -s --standard=phpcs.xml,vendor/codeigniter4/codeigniter4-standard/CodeIgniter4/ruleset.xml %1
CALL vendor\bin\phpcs -s --standard=ruleset.xml %1
