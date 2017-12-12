{pkgs ? import <nixpkgs> {
    inherit system;
  }, system ? builtins.currentSystem, noDev ? false}:

let
  composerEnv = import ./composer-env.nix {
    inherit (pkgs) stdenv writeTextFile fetchurl unzip;
    php = import ./hhvm.nix;
  };
in
import ./php-packages.nix {
  inherit composerEnv noDev;
  inherit (pkgs) fetchurl fetchgit fetchhg fetchsvn;
}