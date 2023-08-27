linter-autofix:
	./vendor/bin/php-cs-fixer fix -v --using-cache=no
	./vendor/bin/rector

analyze:
	./vendor/bin/phplint
	./vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no
	./vendor/bin/rector --dry-run
	./vendor/bin/phpstan --memory-limit=-1
	./vendor/bin/psalm --no-cache $(ARGS)
	./vendor/bin/phpunit
