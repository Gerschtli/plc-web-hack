with import <nixpkgs> { };

stdenv.mkDerivation {
  name = "plc-web-hack";

  src = ./.;

  phases = [ "unpackPhase" "installPhase" ];

  installPhase = "cp -R . \$out";
}
