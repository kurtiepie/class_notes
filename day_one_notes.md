# Create basic container
```
docker run -it alpine /bin/sh -c 'ping 4.2.2.2'
```

# Host mount a volume into the container
```
docker run -v$PWD:/kurtis -it alpine:3.10 /bin/sh -c 'ls /kurtis'
```

# run as container registry as daemon
```
docker run -d --restart=always -p "127.0.0.1:5000:5000" --name registry registry:2
```

# verify registry
```
curl http://127.0.0.1:5000/v2/_catalog
```

# create base image 
# Dockerfile
```
FROM alpine:3.10

RUN apk add vim
```

# Build
```
docker build . -t myimage:3.10
```

# Check registry
curl http://127.0.0.1:5000/v2/_catalog

# Rebuild  for registry
```
docker build . -t 127.0.0.1:5000/myimage:3.10
```

# PUSH
```
docker push 127.0.0.1:5000/myimage:3.10
```

# Verify check
curl http://127.0.0.1:5000/v2/_catalog

# Trivy Scan for CVE's
```
trivy image --severity HIGH,CRITICAL 127.0.0.1:5000/myimage:3.10
```

---

# Build Headers

## Test go app
```
package main

import (
      "fmt"
      "log"
      "net/http"
      "os"
)

type EnvVars struct {
      Port string
}

func GetEnv() EnvVars {
      port := os.Getenv("PORT")
      if port == "" {
        log.Fatal("ENVIORMENT VARIABLE 'PORT' Missing")
      }

      return EnvVars{
        Port: port,
      }
}

func HomeHandler(w http.ResponseWriter, r *http.Request) {
      log.Println("Got a connection")
      for k, v := range r.Header {
        fmt.Fprintf(w, "%v: %v\n", k, v)
      }

}

func main() {
      envVars := GetEnv()
      port := fmt.Sprintf(":%v", envVars.Port)

      log.Println("Starting on PORT: ", port)
      http.HandleFunc("/hello", HomeHandler)
      http.ListenAndServe(port, nil)
}
```

# Initialize the module
```
go mod init headers
```

# Step one test app from local
```
PORT=45678 go run main.go
curl http://127.0.0.1:45678/hello
```

# Build new docker file for headers
## Dockerfile-headers
```
cat > Dockerfile-headers <<EOF
FROM golang:1.16-alpine as builder

WORKDIR /app

COPY *.go ./

COPY go.mod ./

RUN go build -o ./headers

FROM alpine:3.10

COPY --from=builder /app/headers /bin/headers

ENV PORT 45678

CMD ["/bin/headers"]
EOF 
```
# Build headers image and tag for local registry
```
docker build -f Dockerfile-headers . -t 127.0.0.1:5000/headers:0.1
```

# Run the docker applicatoin and test
```
docker run -d -p45678:45678 127.0.0.1:5000/headers:0.1
curl http://127.0.0.1:45678/hello
```

# Basic Makefile for steps
```
cat <<EOF > Makefile
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
EOF
```
# Capabilites
```
docker build -f Dockerfile-cap . -t 127.0.0.1:5000/caps:0.1
```

# Test DROPALL CAPS
```
docker run --cap-drop ALL -it 127.0.0.1:5000/caps:0.1 /bin/sh -c 'ping 4.2.2.2'
```

# Test by adding cap+net+raw
```
docker run --cap-drop ALL --cap-add CAP_NET_RAW -it 127.0.0.1:5000/caps:0.1 /bin/sh -c 'ping 4.2.2.2'
```
