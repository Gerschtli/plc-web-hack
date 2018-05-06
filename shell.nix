with import <nixpkgs> { };

stdenv.mkDerivation {
  name = "plc-web-hack";

  buildInputs = [
    phpPackages.composer
    hhvm
  ];
}
