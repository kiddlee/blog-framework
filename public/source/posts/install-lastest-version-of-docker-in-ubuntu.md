##use apt-get

* Add the Docker repository key to your local keychain
```
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 36A1D7869245C8950F966E92D8576A8BA88D21E9
```
* Add the Docker repository to your apt sources list.
```
sudo sh -c "echo deb https://get.docker.io/ubuntu docker main > /etc/apt/sources.list.d/docker.list"
```
* update your sources list
```
sudo apt-get update
```
* install the latest
```
sudo apt-get install lxc-docker
```
