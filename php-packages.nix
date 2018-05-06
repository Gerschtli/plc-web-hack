{composerEnv, fetchurl, fetchgit ? null, fetchhg ? null, fetchsvn ? null, noDev ? false}:

let
  packages = {
    "facebook/xhp-lib" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "facebook-xhp-lib-5ef653637aa15aed232ff913b3c66b346df0932a";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/xhp-lib/zipball/5ef653637aa15aed232ff913b3c66b346df0932a;
          sha256 = "18vfr521azadlzn0nznc0kgfsp6qlvgli2fp2lzsjch3fan65jwy";
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
        name = "hhvm-hhvm-autoload-2beebbb5982e77237ec853ee1231860c3c295bf3";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/hhvm-autoload/zipball/2beebbb5982e77237ec853ee1231860c3c295bf3;
          sha256 = "0pnbnfblyjpdfvaq90hnnrjcriz20p56drwqv833yvxynml23cpk";
        };
      };
    };
    "hhvm/hsl" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hhvm-hsl-2d40281ec595b25a09bbe51d9216edbf1ad55a42";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/hsl/zipball/2d40281ec595b25a09bbe51d9216edbf1ad55a42;
          sha256 = "0ihqhv054s4iyr9dnid7jrafi44v7cn9s2ldgczkah6j16kz37nl";
        };
      };
    };
    "hhvm/type-assert" = {
      targetDir = "";
      src = composerEnv.buildZipPackage {
        name = "hhvm-type-assert-8f70814c8268f50e2fa728893d3ad9cad73df398";
        src = fetchurl {
          url = https://api.github.com/repos/hhvm/type-assert/zipball/8f70814c8268f50e2fa728893d3ad9cad73df398;
          sha256 = "12h4bv5q3zi5kags28hxbq13i2hd0nfpws5kkakrz9jmdi0034d1";
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