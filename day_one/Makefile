build:
	docker build --no-cache . -t 127.0.0.1:5000/myimage:0.1

push: ## Push to local registry
	docker push 127.0.0.1:5000/myimage:0.1

cve-scan:
	docker scout cves

trivy-scan:
	trivy image --severity HIGH,CRITICAL 127.0.0.1:5000/myimage:0.1

test: ## Push to local registry
	docker run -it  127.0.0.1:5000/myimage:0.1 /bin/sh -c "uptime"
