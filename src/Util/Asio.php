<?hh // strict

namespace PLC\Util;

use function HH\Asio\v;

class Asio
{
    /**
     * Wrap \HH\Asio\v for right types.
     *
     * @param  Awaitable<T1> $one  First async call
     * @param  Awaitable<T2> $two  Second async call
     * @return (T1, T2)            Results in tuple
     */
    public async function batch<T1, T2>(
        Awaitable<T1> $one,
        Awaitable<T2> $two
    ): Awaitable<(T1, T2)>
    {
        $list = await v(
            Vector {
                $one,
                $two,
            }
        );

        // UNSAFE
        return tuple($list[0], $list[1]);
    }

    /**
     * Wrap \HH\Asio\v for right types.
     *
     * @param  Awaitable<T1> $one    First async call
     * @param  Awaitable<T2> $two    Second async call
     * @param  Awaitable<T3> $three  Third async call
     * @return (T1, T2, T3)          Results in tuple
     */
    public async function batchThree<T1, T2, T3>(
        Awaitable<T1> $one,
        Awaitable<T2> $two,
        Awaitable<T3> $three
    ): Awaitable<(T1, T2, T3)>
    {
        $list = await v(
            Vector {
                $one,
                $two,
                $three,
            }
        );

        // UNSAFE
        return tuple($list[0], $list[1], $list[2]);
    }
}
