<?hh // strict

namespace PLC\Util;

enum InputType: string as string
{
    MUTLI_LINE_TEXT = 'textarea';
    ONE_LINE_TEXT   = 'text';
    PASSWORD        = 'password';
}
