DOCKER_COMPOSE ?= docker compose
PHP_SERVICE ?= php
MYSQL_SERVICE ?= mysql
PHPUNIT ?= vendor/bin/phpunit
NPM ?= npm
TEST_DB_SQL := CREATE DATABASE IF NOT EXISTS app_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; GRANT ALL PRIVILEGES ON app_test.* TO 'app'@'%';

.PHONY: css test test-unit test-integration test-db

css:
	$(NPM) run build:css

test: test-db
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) $(PHPUNIT)

test-unit:
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) $(PHPUNIT) --testsuite Unit

test-integration: test-db
	$(DOCKER_COMPOSE) exec $(PHP_SERVICE) $(PHPUNIT) --testsuite Integration

test-db:
	$(DOCKER_COMPOSE) exec $(MYSQL_SERVICE) sh -c "MYSQL_PWD=root mysql -uroot -e \"$(TEST_DB_SQL)\" 2>/dev/null || mysql -uroot -e \"$(TEST_DB_SQL)\""
