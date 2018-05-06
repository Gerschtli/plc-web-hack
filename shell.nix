with import <nixpkgs> { };

let
  composer = phpPackages.composer.overrideAttrs (old: {
    name = "hhvm-composer";

    installPhase = ''
      mkdir -p $out/bin
      install -D $src $out/libexec/composer/composer.phar
      makeWrapper ${hhvm}/bin/hhvm $out/bin/composer \
        --add-flags "$out/libexec/composer/composer.phar"
    '';
  });
in

stdenv.mkDerivation {
  name = "plc-web-hack";

  buildInputs = [
    composer
    hhvm
  ];
}
