mkdir -p /opt/docker-registry/cert
cd /opt/docker-registry/cert

openssl req -newkey rsa:2048 -nodes -keyout registry_auth.key -x509 -days 365 -out registry_auth.crt -config ext.cfg -extensions v3_req

mkdir -p /opt/docker-registry/auth
cd /opt/docker-registry/auth

htpasswd -Bbn admin password >> /opt/docker-registry/auth/htpasswd


# docker run -d -p 5000:5000 --restart=always --name registry \
  -v /opt/docker-registry/data:/var/lib/registry \
  -v /opt/docker-registry/auth:/auth \
  -e "REGISTRY_AUTH=htpasswd" \
  -e "REGISTRY_AUTH_HTPASSWD_REALM=Registry Realm" \
  -e REGISTRY_AUTH_HTPASSWD_PATH=/auth/htpasswd \
  -v /opt/docker-registry/certs:/certs \
  -e REGISTRY_HTTP_TLS_CERTIFICATE=/certs/registry_auth.crt \
  -e REGISTRY_HTTP_TLS_KEY=/certs/registry_auth.key \
  registry:2

# Auth in
falcoctl registry auth basic kurtisvelarde.com:5000

# Create basic rull
cat <EOF > my_rules.yaml
- list: falco_binaries
  items: [falcoctl]
EOF

# Tar for transport
tar cvzf myrules.tar.gz my_rules.yaml

# Push
falcoctl registry push  --type rulesfile --version "0.1.2" kurtisvelarde.com:5000/myrulesfile:latest myrules.tar.gz

# Pull
falcoctl registry pull kurtisvelarde.com:5000/myrulesfile:latest --dest-dir=./myDir

# Add new Registry
falcoctl index add kurtis-rules  https://kurtisvelarde.com/falco/index.yaml


falcoctl index update kurtis-rules

falcoctl artifact list

falcoctl -v artifact install application-rules

# Example index with namespaced rules
```sh
- name: kurtis-falco-main-rules
  type: rulesfile
  registry: kurtisvelarde.com:5000
  repository: rules/kurtis-falco-main
  description: This rules files is maintained by kurtis that are the defualt set
  home: https://github.com/falcosecurity/rules/blob/main/archive/application_rules.yaml
  keywords:
    - kurtis-rules
  license: apache-2.0
  maintainers:
    - email: kurtis@kurtisvelarde.com
      name: kurtis
  sources:
    - https://github.com/falcosecurity/rules/blob/main/archive/application_rules.yaml
```

# Push to it
```sh
falcoctl registry push  --type rulesfile --version "0.1.2" kurtisvelarde.com:5000/rules/kurtis-falco-main:0.1 kurtis-falco-main_rules.yaml
```

# Pull
```sh
falcoctl registry pull kurtisvelarde.com:5000/rules/kurtis-falco-main:0.1 --dest-dir=~/rules
tar xvzf ~/rules/kurtis-falco-main_rules.tar.gz kurtis-falco-main_rules.yaml
```

# Copy
```sh

cp kurtis-falco-main_rules.yaml /etc/falco/rules.d/
```

# Restart
```sh
systemctl restart falco
