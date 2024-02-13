DOCKER := docker-compose -f docker-compose.yml
DOCKER_EXEC_ROOT := $(DOCKER) exec -u "root:root" php-fpm

.PHONY: start
start: ## Start local server
	$(DOCKER) up -d

.PHONY: stop
stop: ## Stop local server
	$(DOCKER) down

.PHONY: bash
bash: ## Enter to the php-fpm container
	$(DOCKER_EXEC_ROOT) bash