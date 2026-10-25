#!/bin/bash
set -euo pipefail   # strict mode

cd "$(dirname "${BASH_SOURCE[0]}")"
cd ..

DevelopmentTools/Common/Commands/composerStatus.sh

DevelopmentTools/Common/Commands/npmStatus.sh

echo
echo -e "\e[36mChecking JavaScript...\e[0m"
npx eslint DevelopmentTools/minify.js

echo
echo -e "\e[36mMinifying assets...\e[0m"
node DevelopmentTools/minify.js

echo
echo -e "\e[36mChecking code syntax...\e[0m"
vendor/bin/parallel-lint --exclude .git --exclude vendor .

echo
echo -e "\e[36mCode Analysis...\e[0m"
vendor/bin/phpstan.phar analyse

echo
echo -e "\e[36mChecking code styles...\e[0m"
vendor/bin/phpcs -sp --standard=ruleset.xml SourceCode
vendor/bin/phpcs -sp --standard=ruleset.tests.xml Tests

echo
echo -e "\e[36mRunning Automated Tests...\e[0m"
vendor/bin/phpunit --configuration Tests/phpunit.xml

if [[ $1 == "release" ]] ; then
	echo "Release Is Set!"

	# rm -rf Documentation
	# phpDocumentor.phar --setting="graphs.enabled=true" -d SourceCode -t Documentation

	zip -r digitalzenworks-inferret.zip SourceCode/themes/digitalzenworks-inferret
	gh release create v$2 --notes $2 digitalzenworks-inferret.zip
	rm digitalzenworks-inferret.zip
fi
