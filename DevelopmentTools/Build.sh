#!/bin/bash
set -euo pipefail   # strict mode

cd "$(dirname "${BASH_SOURCE[0]}")"
cd ..

echo
echo -e "\e[36mChecking composer...\e[0m"
composer install --prefer-dist
composer validate --strict
echo
echo -e "\e[36mOutdated:\e[0m"
composer outdated --direct || true
echo
echo -e "\e[36mSecurity audit:\e[0m"
composer audit

echo
echo -e "\e[36mChecking npm...\e[0m"
npm install
echo
echo -e "\e[36mOutdated:\e[0m"
npm outdated --depth=0 || true
echo
echo -e "\e[36mSecurity audit (high level):\e[0m"
npm audit --audit-level=high
echo
echo -e "\e[36mSecurity audit (normal level):\e[0m"
npm audit

echo
echo -e "\e[36mChecking JavaScript...\e[0m"
npx eslint DevelopmentTools/minify.js

echo
echo -e "\e[36mMinifying assets...\e[0m"
node DevelopmentTools/minify.js

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
