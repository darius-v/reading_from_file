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
	docker compose exec php php /var/www/html/testFramework/run.php http://nginx:80
