DIRS:=Constraint/ Contract/ Entity/ Model/ Repository/ Service/ Trait/

help:
	@echo "cs-check                    Validating coding standards rules"
	@echo "cs-fix                      Fix coding standards"
	@echo "phpmd                       Run PHP Mess Detector"
	@echo "psalm                       Run Psalm analyse"

cs-fix:
	@echo "Fix coding standards"
	php vendor/bin/php-cs-fixer fix ${DIRS} --verbose --config=.php-cs-fixer.dist.php

cs-check:
	@echo "Validating coding standards rules"
	php vendor/bin/phpcs --standard=PSR12 -s --colors --extensions=php ${DIRS}

phpmd:
	@echo "Running PHP Mess Detector"
	php -d memory_limit=4G vendor/bin/phpmd Constraint text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Contract text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Entity text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Model text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Repository text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Service text phpmd.xml
	php -d memory_limit=4G vendor/bin/phpmd Trait text phpmd.xml

psalm:
	@echo "Running Psalm"
	php -d memory_limit=4G vendor/bin/psalm --taint-analysis


analysis:
	$(MAKE) cs-check
	$(MAKE) psalm
	$(MAKE) phpmd

before-push:
	$(MAKE) cs-fix
	$(MAKE) psalm
	$(MAKE) phpmd
