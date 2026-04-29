.PHONY: up down restart bash test

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart

bash:
	docker compose exec php bash

test:
	docker compose exec -e PHP_IDE_CONFIG="serverName=localhost" -e XDEBUG_SESSION=PHPSTORM php php /var/www/html/testFramework/run.php http://nginx:80
