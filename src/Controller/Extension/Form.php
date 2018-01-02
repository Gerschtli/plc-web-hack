<?hh // strict

namespace PLC\Controller\Extension;

use PLC\Controller\Controllable;
use PLC\Util\Globals;
use PLC\Validator\Validator;

trait Form<T>
{
    require implements Controllable;

    private async function _handleForm(
        Globals $globals,
        Validator<T> $validator,
        (function(Map<string, string>): T) $modelBuilder,
        (function(T): Awaitable<void>) $successCallback
    ): Awaitable<shape('errors' => Vector<string>, 'model' => ?T, 'success' => bool)>
    {
        $post = $globals->getPost();

        if (!$post->containsKey('submit')) {
            return shape('errors' => Vector {}, 'model' => null, 'success' => false);
        }

        $model  = $modelBuilder($post);
        $errors = await $validator->validate($model);

        if ($errors->isEmpty()) {
            await $successCallback($model);
        }

        return shape('errors' => $errors, 'model' => $model, 'success' => $errors->isEmpty());
    }
}
