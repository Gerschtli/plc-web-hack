# NOTE: execute init.sql in mysql shell in container

rec {
  description = "PLC Web Hack";

  plc-hack =
    { pkgs, appDir ? null, dev ? false }:
    let
      app = import ../. { noDev = !dev; };
      public = (
        if (appDir != null)
        then appDir
        else app
      ) + "/public";
    in
    {
      networking.firewall = {
        enable = true;
        allowedTCPPorts = [ 80 ];
        allowPing = true;
      };

      nixpkgs.overlays = [
        (self: super:
          {
            hhvm = import ../hhvm.nix;
          }
        )
      ];

      services = {
        mysql = {
          enable = true;
          package = pkgs.mysql;
          ensureDatabases = [ "blog" ];
        };

        nginx = {
          enable = true;
          recommendedOptimisation = true;
          recommendedGzipSettings = true;

          virtualHosts."plc.hack".locations = {
            "/" = {
              extraConfig = ''
                fastcgi_keep_conn on;
                fastcgi_pass   127.0.0.1:9000;
                include        ${pkgs.nginx}/conf/fastcgi_params;
                fastcgi_param  SCRIPT_FILENAME ${public}/index.php;
              '';
            };
            "~* \.(png|gif|jpg|jpeg|ico|css|js|woff|ttf|otf|woff2|eot)$" = {
              root = public;
              tryFiles = "$uri /";
            };
          };
        };
      };

      system.activationScripts.mysql-socket = ''
        ${pkgs.coreutils}/bin/ln -snf /run/mysqld/mysqld.sock /tmp/mysql.sock
      '';

      systemd.services.hhvm-server = {
        description = "HHVM Server";
        after = [ "network.target" ];
        wantedBy = [ "multi-user.target" ];
        path = with pkgs; [
          bash
          eject # for dmesg
          gnutar
          gzip
          pandoc
        ];
        serviceConfig = {
          ExecStart = ''
            ${pkgs.hhvm}/bin/hhvm --mode server \
              -d hhvm.server.type=fastcgi \
              -d hhvm.server.port=9000 \
              -vRepo.Central.Path=/var/tmp/.hhvm.hhbc
          '';
          User = "nginx";
          Restart = "always";
          KillSignal = "SIGKILL";
        };
      };

      time.timeZone = "Europe/Berlin";
    };
}
