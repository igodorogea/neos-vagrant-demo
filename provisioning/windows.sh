#!/usr/bin/env bash

if [[ ! `which ansible-playbook` ]]; then
	sudo apt install -y software-properties-common
	sudo apt-add-repository ppa:ansible/ansible -y
	sudo apt update
	sudo apt upgrade -y
	sudo apt autoremove
	sudo apt autoclean
	sudo apt install -y ansible
fi

# Setup Ansible for Local Use and Run
# cp /vagrant/inventories/dev /etc/ansible/hosts -f
# chmod 666 /etc/ansible/hosts
# sudo ansible-playbook /vagrant/playbook.yml -e hostname=$1 -c local

sudo ansible-playbook /vagrant/playbook.yml -i "localhost," -c local
