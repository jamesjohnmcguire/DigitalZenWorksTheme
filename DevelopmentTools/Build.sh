#!/bin/bash

cd "$(dirname "${BASH_SOURCE[0]}")"
cd ..

echo Checking composer...
composer install --prefer-dist
composer validate --strict
echo outdated:
composer outdated --direct

echo Checking npm...
npm install
npm outdated

echo Checking syntax...
vendor/bin/parallel-lint --exclude .git --exclude vendor .

echo ""
echo Code Analysis...
vendor/bin/phpstan.phar analyse

echo Checking code styles...
vendor/bin/phpcs -sp --standard=ruleset.xml SourceCode
vendor/bin/phpcs -sp --standard=ruleset.tests.xml Tests

vendor/bin/phpunit --config Tests/phpunit.xml

if [[ $1 == "release" ]] ; then
	echo "Release Is Set!"

	# rm -rf Documentation
	# phpDocumentor.phar --setting="graphs.enabled=true" -d SourceCode -t Documentation

	zip -r digitalzenworks-inferret.zip SourceCode/themes/digitalzenworks-inferret
	gh release create v$2 --notes $2 digitalzenworks-inferret.zip
	rm digitalzenworks-inferret.zip
fi
