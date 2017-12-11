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
            hhvm = super.hhvm.overrideDerivation (old: rec {
              name = "hhvm-${version}";
              version = "3.23";

              src = super.fetchgit {
                url    = "https://github.com/facebook/hhvm.git";
                rev    = "3cc1735c3ab1690611ad8443094d2ccf951645ad";
                sha256 = "1nic49j8nghx82lgvz0b95r78sqz46qaaqv4nx48p8yrj9ysnd7i";
                fetchSubmodules = true;
              };
            });
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
            };
          };
        };
      };

      systemd.services.hhvm-server = {
        description = "HHVM Server";
        after = [ "network.target" ];
        wantedBy = [ "multi-user.target" ];
        path = with pkgs; [
          bash
          eject # for dmesg
          gnutar
          gzip
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
        };
      };

      time.timeZone = "Europe/Berlin";
    };
}
