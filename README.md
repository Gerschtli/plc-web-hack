# Hack project for Programming Language Competetion - Group: Web

Purpose of this project was to show the core features of the [Hack](https://docs.hhvm.com/hack/) language.
I didn't pay security and UI much attention, it was only for a course at my university, but I had the desire to show
the world what I have done.

Some general comments: I had to write my own little micro framework because of the lack of existing and currently
maintained frameworks.

I developed this project under heavy use of the [NixOS](https://nixos.org/) eco system: the
[nix package manager](https://nixos.org/nix/) to install [hhvm](https://docs.hhvm.com/) and
[composer](https://getcomposer.org/) via `nix-shell` into my `PATH` and the
[nixops deployment tool](https://nixos.org/nixops/) to set up a local VirtualBox VM and to deploy the application
to a production environment.

## Development

### Dependencies

With [composer](https://getcomposer.org/):
```sh
$ hhvm bin/composer install
```

Or within `nix-shell`:
```sh
[nix-shell]$ composer install
```

#### Dependencies Update

After each dependency update, the nix-ified version of the composer dependencies (needed for production deployments)
should be updated with my forked [composer2nix for hhvm](https://github.com/Gerschtli/composer2nix/) tool, too:
```sh
$ composer update
$ composer2nix/bin/composer2nix
```

### VM

With `nixops`:
```sh
$ # only needed for the first time
$ nixops/manage dev create "<nixops/dev.nix>"
$ # provision changes to VM
$ nixops/manage dev deploy
$ # start/stop VM
$ nixops/manage dev start
$ nixops/manage dev stop
$ # run nixops/init.sql in container
$ nixops/manage dev ssh-for-each -- "mysql < /var/www/plc-hack/nixops/init.sql"
$ # info to VM (e.g. IP of VM)
$ nixops/manage dev info
```

Note: You need to install VirtualBox.

### FAQ's

#### The nixops deployment failed with some systemd gibberish like the following. Why doesn't anything work on first try?!
```
plc-hack> ● virtualbox.service - VirtualBox Guest Services
plc-hack>    Loaded: loaded (/nix/store/hri8mh4id3v4nvjsbyvc4y8phra47nzh-unit-virtualbox.service/virtualbox.service; enabled; vendor preset: enabled)
plc-hack>    Active: failed (Result: exit-code) since Sun 2018-05-06 22:36:03 CEST; 5s ago
plc-hack>   Process: 1446 ExecStart=VBoxService --foreground (code=exited, status=1/FAILURE)
plc-hack>  Main PID: 1446 (code=exited, status=1/FAILURE)
plc-hack>
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.006256 main     OS Product: Linux
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.006375 main     OS Release: 4.4.24
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.006855 main     OS Version: #1-NixOS SMP Fri Oct 7 13:23:59 UTC 2016
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.007716 main     Executable: /nix/store/flidw2g4i3x45kkwhzvflxvnqb704vrk-VirtualBox-GuestAdditions-5.2.8-4.14.39/bin/VBoxService
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.007717 main     Process ID: 1446
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.007717 main     Package type: LINUX_64BITS_GENERIC
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.024335 main     Error: Failed to connect to the guest property service, rc=VERR_INTERNAL_ERROR
plc-hack> May 06 22:36:03 plc-hack VBoxService[1446]: 00:00:00.024662 main     Error: Service 'control' failed pre-init: VERR_INTERNAL_ERROR
plc-hack> May 06 22:36:03 plc-hack systemd[1]: virtualbox.service: Main process exited, code=exited, status=1/FAILURE
plc-hack> May 06 22:36:03 plc-hack systemd[1]: virtualbox.service: Failed with result 'exit-code'.
plc-hack>
plc-hack> ● get-vbox-nixops-client-key.service - Get NixOps SSH Key
plc-hack>    Loaded: loaded (/nix/store/32xap1y02pmz4j9v394j7jjx9d8xp3sk-unit-get-vbox-nixops-client-key.service/get-vbox-nixops-client-key.service; enabled; vendor preset: enabled)
plc-hack>    Active: failed (Result: exit-code) since Sun 2018-05-06 22:36:03 CEST; 5s ago
plc-hack>   Process: 1455 ExecStart=/nix/store/1y5g8yw8xj2d77xrg5a7hxgry9jgvlfg-unit-script/bin/get-vbox-nixops-client-key-start (code=exited, status=1/FAILURE)
plc-hack>  Main PID: 1455 (code=exited, status=1/FAILURE)
```

As usual in the internet I am blaming someone else. It seems that nixops uses an old base image (NixOS 16.09) that fails
to update straight to the current used NixOS 18.03 ([see issue](https://github.com/NixOS/nixops/issues/908)).
A simple reboot does the trick:
```sh
$ nixops/manage dev deploy --force-reboot
```

#### I got some crazy PHP Database Connection Error messages. What is happening?

I got you boy. Because I am too lazy to implement some database provisioning, I write this FAQ ;)
Just run the following and you are ready to go:
```sh
$ nixops/manage dev ssh-for-each -- "mysql < /var/www/plc-hack/nixops/init.sql"
```

#### Where are my runtime errors?

Just have a look at `journalctl` in your VM, there is everything you need for your happiness:
```sh
$ nixops/manage dev ssh plc-hack
[root@plc-hack:~]$ journalctl -f
```

## Deployment

```sh
$ # only needed for the first time
$ nixops/manage prod create "<nixops/prod.nix>"
$ # deploy
$ nixops/manage prod deploy --check
```

Note: You need to configure the ssh connection (hostname: `app.plc-web`) manually!
