DOCKER := docker-compose -f docker-compose.yml
DOCKER_EXEC_ROOT := $(DOCKER) exec -u "root:root" php-fpm

.PHONY: start
start: ## Start local server
	$(DOCKER) up -d

.PHONY: setup
setup: ## Start local server and create the tables
	$(DOCKER) up -d
	$(DOCKER_EXEC_ROOT) php bin/console doctrine:schema:update --force

.PHONY: stop
stop: ## Stop local server
	$(DOCKER) down

.PHONY: bash
bash: ## Enter to the php-fpm container
	$(DOCKER_EXEC_ROOT) bash

.PHONY: unit
unit: ## Run only phpunit tests
	$(DOCKER_EXEC_ROOT) vendor/bin/phpunit tests/

.PHONY: collect-bookings
collect-bookings: ## Execute a symfony command to collect the bookings since '2024-02-02 00:00:00'
	$(DOCKER_EXEC_ROOT) php bin/console app:bookings:collect '2024-02-02 00:00:00'