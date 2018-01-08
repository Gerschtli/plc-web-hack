# Hack project for PLC Web

## Build and run

### Dependencies

With [composer](https://getcomposer.org/):
```sh
$ hhvm bin/composer install
```

### VM

With `nixops` (see [nixops deployment tool](https://nixos.org/nixops/)):
```sh
$ # only needed for the first time
$ nixops/manage dev create "<nixops/dev.nix>"
$ # provision changes to vm
$ nixops/manage dev deploy
$ # start/stop vm
$ nixops/manage dev start
$ nixops/manage dev stop
$ # run nixops/init.sql in container
$ nixops/manage dev ssh-for-each -- "mysql < /var/www/plc-hack/nixops/init.sql"
```

Note: You need to install VirtualBox.

## Deployment

```sh
$ nixops/manage prod deploy --check
```

Note: You need to configure the ssh connection (hostname: `app.plc-web`) manually!
