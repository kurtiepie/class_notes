REG_URL := "localhost:5000"
NAME := "myimage"
VERSION := "0.1"

deploy-dvwa: ## Deploy Damn Vulnerable Web App
	@kubectl apply -f deployment_yamls/
	@kubectl wait --for=condition=ready pod -l app=dvwa-web
	@echo Now cp Config to container
	@kubectl get pods -l app=dvwa-web
	@echo kubectl cp $PWD/config.php default/dvwa-web-566855bc5b-cfpc5:/var/www/html/config/config.inc.php

delete-dvwa: ## Delete Damn Vulnerable Web App
	@kubectl delete -f deployment_yamls/

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
