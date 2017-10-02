# -*- mode: ruby -*-
# vi: set ft=ruby :

#If your Vagrant version is lower than 1.5, you can still use this provisioning
#by commenting or removing the line below and providing the config.vm.box_url parameter,
#if it's not already defined in this Vagrantfile. Keep in mind that you won't be able
#to use the Vagrant Cloud and other newer Vagrant features.
Vagrant.require_version ">= 1.5"

# Check to determine whether we're on a windows or linux/os-x host,
# later on we use this to launch ansible in the supported way
# source: https://stackoverflow.com/questions/2108727/which-in-ruby-checking-if-program-exists-in-path-from-ruby
def which(cmd)
    exts = ENV['PATHEXT'] ? ENV['PATHEXT'].split(';') : ['']
    ENV['PATH'].split(File::PATH_SEPARATOR).each do |path|
        exts.each { |ext|
            exe = File.join(path, "#{cmd}#{ext}")
            return exe if File.executable? exe
        }
    end
    return nil
end

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"


Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    # All Vagrant configuration is done here. The most common configuration
    # options are documented and commented below. For a complete reference,
    # please see the online documentation at vagrantup.com.

    # Every Vagrant virtual environment requires a box to build off of.
    config.vm.box = "ubuntu/xenial64"


    config.vm.provider "virtualbox" do |vb|
        #vb.gui = true

        vb.name = "neos-demo-vagrant"

        vb.customize [
            "modifyvm", :id,
            "--name", "neos-demo-vagrant",
            "--memory", "1024",
            "--natdnshostresolver1", "on",
            "--cpus", 2,
        ]

        vb.customize [
            "setextradata", :id,
            "VBoxInternal2/SharedFoldersEnableSymlinksCreate/v-root", "1"
        ]
    end


    #config.vm.network "forwarded_port", guest: 80, host: 8080
    #config.vm.network "forwarded_port", guest: 3306, host: 3306
    #config.vm.network "forwarded_port", guest: 3307, host: 3307

    config.vm.network :private_network, ip: "192.168.33.140"

    config.ssh.forward_agent = true


    #############################################################
    # Ansible provisioning (you need to have ansible installed)
    #############################################################

    if which('ansible-playbook')
        config.vm.provision :ansible do |ansible|
            ansible.playbook = "provisioning/playbook.yml"
            ansible.inventory_path = "provisioning/inventories/dev"
            ansible.limit = 'all'
            # ansible.verbose = 'vv'
        end
    else
        config.vm.provision :shell, path: "provisioning/windows.sh", args: ["neos-demo-vagrant"]
    end

    if which('ansible-playbook')
        config.vm.synced_folder ".", "/vagrant", disabled: true
        #config.vm.synced_folder "./", "/var/www/vhosts/localhost", type: "nfs"
    else
        config.vm.synced_folder "./provisioning", "/vagrant"
    end

    config.vm.synced_folder "./Configuration", "/var/www/neos-demo-vagrant/Configuration", owner: "www-data", group: "www-data"
    config.vm.synced_folder "./Packages/Sites", "/var/www/neos-demo-vagrant/Packages/Sites", owner: "www-data", group: "www-data"
    config.vm.synced_folder "./composer", "/var/www/neos-demo-vagrant/composer", owner: "www-data", group: "www-data"
    config.vm.synced_folder "./.surf", "/var/www/neos-demo-vagrant/.surf", owner: "www-data", group: "www-data"
end
