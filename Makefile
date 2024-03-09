build:
	docker build . -t php_attr_reflection_image -f Dockerfile

composer-update: build
	docker run -w /app -v $(shell pwd):/app php_attr_reflection_image composer update
	sudo chmod 777 -R vendor

composer-install: build
	docker run -w /app -v $(shell pwd):/app php_attr_reflection_image composer install
	sudo chmod 777 -R vendor

phpstan:
	docker run -w /app -v $(shell pwd):/app php_attr_reflection_image composer phpstan

phpunit:
	docker run -w /app -v $(shell pwd):/app php_attr_reflection_image composer phpunit
