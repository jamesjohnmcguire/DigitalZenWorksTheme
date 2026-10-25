# Repository Guidelines

## Project Structure & Module Organization

`SourceCode/` is the installable classic WordPress theme. Its root holds PHP templates and `functions.php`; `template-parts/` and `inc/` hold reusable templates and features. CSS, JavaScript, Sass, and vendor assets currently live in `SourceCode/assets/`. `Tests/` holds PHPUnit tests, and `DevelopmentTools/` holds local build scripts. `../DigitalZenWorksTheme` is a separate theme; do not change it as part of this rebuild. The pre-rebuild theme is preserved on `archive/pre-rebuild-2026-10-24`.

## Build, Test, and Development Commands

Run these from the repository root:

- `composer install` and `npm ci`: install locked PHP and Node development dependencies.
- `npm run build`: generate ignored minified CSS and JavaScript from the current theme assets.
- `git submodule update --init`: fetch shared status scripts into `DevelopmentTools/Common` after cloning.
- `bash DevelopmentTools/build.sh` or `DevelopmentTools\build.cmd`: install and audit dependencies, lint and minify assets, generate the POT file, run PHP analyzers, and run PHPUnit. The build stops when a check fails.
- `composer test`: run the PHPUnit suite in `Tests/phpunit.xml`.
- `npx eslint DevelopmentTools/minify.js`: lint the asset builder.
- `php vendor/bin/phpstan analyse` and `php vendor/bin/phpcs --standard=ruleset.xml SourceCode`: run static analysis and PHP coding checks. Legacy theme code currently has findings in these checks.

For local testing, place or link `SourceCode/` under a WordPress site's `wp-content/themes/`.

## Coding Style & Naming Conventions

Follow `.editorconfig`: UTF-8, final newlines, no trailing whitespace, and four-column tabs for PHP, JavaScript, and CSS. PHP and shell files use LF; `.cmd` files use CRLF. Name development scripts in camelCase, such as `unitTests.cmd` and `minify.js`. Use lowercase, hyphenated PHP template filenames and `digitalzen_` prefixes for theme functions. Target PHP 8.5.12+ within the Composer constraint and WordPress 7.1+. Keep the rebuilt theme based on PHP templates; its planned admin interface is for theme settings.

## Testing Guidelines

The suite currently contains one sanity assertion and has no coverage threshold. Add behavior tests for new features, using PHPUnit `#[Test]` attributes, and register new test files in `Tests/phpunit.xml`. Check affected templates and settings in a local WordPress installation.

## Commit & Pull Request Guidelines

Recent commits use short, focused subjects such as `Clean Up Npm Tooling` and `Use camelCase for Development Scripts`. Keep each layer small and leave it uncommitted for the maintainer to review and commit. Pull requests should describe the change, list checks run, link relevant issues, and include screenshots for visual changes.
