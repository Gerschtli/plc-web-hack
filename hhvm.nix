let
  nixpkgs = import <nixpkgs> { };

  newNixpkgs = import (nixpkgs.fetchFromGitHub {
    owner  = "NixOS";
    repo   = "nixpkgs";
    rev    = "d5d7220770dd85b69eeacc97c29020e49a100987";
    sha256 = "0fj3vjx1w3y8jyllinxm7apmw4fd26gxnnih98ls3bpkwsiywam3";
  }) { };
in

newNixpkgs.hhvm
