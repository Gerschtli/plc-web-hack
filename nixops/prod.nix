let
  app = import ./app.nix;
in

{
  network = {
    description = app.description;
    enableRollback = true;
  };

  plc-hack =
    { lib, pkgs, ... }:
    lib.mkMerge [
      {
        deployment = {
          targetEnv = "container";
          container.host = "app.plc-web";
        };
      }

      (app.plc-hack { inherit pkgs; })
    ];
}
