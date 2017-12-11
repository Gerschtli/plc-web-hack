with import <nixpkgs> { };

stdenv.mkDerivation {
  name = "plc-web-hack";

  buildInputs = [
    (import ./hhvm.nix)
    php
  ];
}
