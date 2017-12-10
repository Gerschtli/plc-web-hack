with import <nixpkgs> { };

lib.overrideDerivation (import ./.) (attrs: {
  buildInputs = attrs.buildInputs ++ [
    (hhvm.overrideDerivation (old: rec {
      name = "hhvm-${version}";
      version = "3.23";

      src = fetchgit {
        url    = "https://github.com/facebook/hhvm.git";
        rev    = "3cc1735c3ab1690611ad8443094d2ccf951645ad";
        sha256 = "1nic49j8nghx82lgvz0b95r78sqz46qaaqv4nx48p8yrj9ysnd7i";
        fetchSubmodules = true;
      };
    }))
  ];
})
