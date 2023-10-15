REG_URL := "localhost:5000"
NAME := "myimage"
VERSION := "0.1"

build: ## Docker Build
	@docker build --no-cache . -t $(REG_URL)/$(NAME):$(VERSION)

push: ## Push to local registry
	@docker push $(REG_URL)/$(NAME):$(VERSION)

cve-scan:
	@docker scout cves

trivy-scan: ## SAST Scan for High and Critical CVEs
	@trivy image --severity HIGH,CRITICAL 127.0.0.1:5000/myimage:0.1

test: ## Push to local registry
	docker run -it  127.0.0.1:5000/myimage:0.1 /bin/sh -c "uptime"

help:
	          @grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
