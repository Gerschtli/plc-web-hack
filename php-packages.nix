{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "facebook/definition-finder" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "facebook-definition-finder-38f37b3eafec26fd5030c0f9f3584fc6493c9a9b";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/definition-finder/zipball/38f37b3eafec26fd5030c0f9f3584fc6493c9a9b;
          sha256 = "1ff0jqb9k3z6hqrjmhyxabk4ih93q74gk9d2k2r1kpvhj28ndyj7";
        };
      };
    };
    "facebook/xhp-lib" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "facebook-xhp-lib-aff764effe546739b19fd59082e92e37ecbc43c8";
        src = fetchurl {
          url = https://api.github.com/repos/facebook/xhp-lib/zipball/aff764effe546739b19fd59082e92e37ecbc43c8;
          sha256 = "05ghm97qzsrww1ycqzpma8pnwyxz8h9dx45jqd5wvvvzhargjq3v";
        };
      };
    };
    "fredemmott/hack-error-suppressor" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "fredemmott-hack-error-suppressor-cb145c771b50f4f4eeec8c9cac4740df3d486a12";
        src = fetchurl {
          url = https://api.github.com/repos/fredemmott/hack-error-suppressor/zipball/cb145c771b50f4f4eeec8c9cac4740df3d486a12;
          sha256 = "1nxb5lkrzqvhwlsbn3ilz6sckjnm81f6cn3rr0mgrwivw86zhw7k";
        };
      };
    };
    "hhvm/hhvm-autoload" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hhvm-hhvm-autoload-e91e24c69118505999e6f7e9e051b03c85f634b4";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/hhvm-autoload/zipball/e91e24c69118505999e6f7e9e051b03c85f634b4;
          sha256 = "17b7p8z4b953c6gsrv7rzscn5lzq3ysm9pbnldpq655fyp6fib48";
        };
      };
    };
    "hhvm/hsl" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hhvm-hsl-8cf59799ea76199bd676570cece84866ac73ddc0";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/hsl/zipball/8cf59799ea76199bd676570cece84866ac73ddc0;
          sha256 = "0lzkjjwv3yl03nb7m55wj7kmd2rnx229jk39r18080x8cadf9l5g";
        };
      };
    };
    "hhvm/type-assert" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hhvm-type-assert-92848dbb1598f1df3f86cc5fab5226d6f68e8282";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/type-assert/zipball/92848dbb1598f1df3f86cc5fab5226d6f68e8282;
          sha256 = "0qyrjazdy9fp2sfzlhsw1m1f7hrdxk7fnlvqp9g1m3jxikhrifnv";
        };
      };
    };
  };
  devPackages = {};
in
composerEnv.buildPackage {
  inherit packages devPackages noDev;
  name = "unmr-plc-web-hack";
  src = ./.;
  executable = false;
  symlinkDependencies = false;
  meta = {
    license = "MIT";
  };
}