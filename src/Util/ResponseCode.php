<?hh // strict

namespace PLC\Util;

enum ResponseCode: int as int
{
    OK                    = 200;
    FOUND                 = 302;
    FORBIDDEN             = 403;
    NOT_FOUND             = 404;
    INTERNAL_SERVER_ERROR = 500;
}
