let
  app = import ./app.nix;
  appDir = "/var/www/plc-hack";
in

{
  network.description = app.description;

  plc-hack =
    { config, lib, pkgs, ... }:
    lib.mkMerge [
      {
        deployment = {
          targetEnv = "virtualbox";

          virtualbox = {
            memorySize = 1024;
            headless = true;

            sharedFolders = {
              plc-hack = {
                hostPath = "/home/tobias/projects/plc-web-hack";
                readOnly = false;
              };
            };
          };
        };

        environment = {
          etc = {
            "hh.conf".text = "enable_on_nfs = true";

            "hhvm/server.ini".text = "hhvm.jit = 0";
          };

          systemPackages = [ pkgs.vim ];
        };

        fileSystems.${appDir} = {
          device = "plc-hack";
          fsType = "vboxsf";
          options = map (key: key + "=" + (toString config.ids.uids.nginx)) [ "uid" "gid" ];
        };

        virtualisation.virtualbox.guest.enable = true;
      }

      (app.plc-hack { inherit pkgs appDir; })
    ];
}
