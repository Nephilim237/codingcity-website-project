# Variables
SYMFONY = symfony
SYMFONY_CONSOLE = $(SYMFONY) console
NPM = npm
PHP_BIN = php bin/console

start:
	$(SYMFONY) serve

start-no-i:
	$(SYMFONY) serve -d

stop:
	$(SYMFONY) server:stop

migration:
	$(SYMFONY_CONSOLE) make:migration

entity:
	$(SYMFONY_CONSOLE) make:entity

controller:
	$(SYMFONY_CONSOLE) make:controller

form:
	$(SYMFONY_CONSOLE) make:form

migrate:
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction

fixtures:
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction

test-migrate:
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction --env=test

database-create:
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists

database-test-create:
	$(SYMFONY_CONSOLE) doctrine:database:create --env=test

database-drop:
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force

database-test-drop:
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force --env=test

cache-clear:
	$(SYMFONY_CONSOLE) cache:clear

run-dev:
	$(NPM) run dev

run-watch:
	$(NPM) run watch