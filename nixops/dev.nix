let
  app = import ./app.nix;
  appDir = "/var/www/plc-hack";
  device = "plc-hack";
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

            sharedFolders.${device}.hostPath = toString ./..;
          };
        };

        environment = {
          etc."hh.conf".text = "enable_on_nfs = true";

          systemPackages = [ pkgs.vim ];
        };

        fileSystems.${appDir} = {
          inherit device;
          fsType = "vboxsf";
          options = map (key: key + "=" + (toString config.ids.uids.nginx)) [ "uid" "gid" ];
        };

        virtualisation.virtualbox.guest.enable = true;
      }

      (app.plc-hack { inherit pkgs appDir; dev = true; })
    ];
}
