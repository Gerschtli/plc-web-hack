<?hh // strict

namespace PLC\Controller\Extension;

use PLC\Controller\Controllable;
use PLC\Util\Globals;
use PLC\Validator\Validatable;

type FormResult<T> = shape('errors' => Vector<string>, 'model' => ?T, 'success' => bool);

/**
 * Controller extension for form support.
 */
trait Form<T>
{
    require implements Controllable;

    /**
     * Validates provided model and runs success callback if form submitted and valid.
     *
     * @param Globals                            $globals          Globals util helper
     * @param Validatable<T>                     $validator        Validator for model
     * @param (function(Map<string, string>): T) $modelBuilder     Model builder based on post data
     * @param (function(T): Awaitable<void>)     $successCallback  Success callback
     * @return FormResult<T>  Errors list, model and success flag
     */
    private async function _handleForm(
        Globals $globals,
        Validatable<T> $validator,
        (function(Map<string, string>): Awaitable<T>) $modelBuilder,
        (function(T): Awaitable<void>) $successCallback
    ): Awaitable<FormResult<T>>
    {
        $post = $globals->getPost();

        if (!$post->containsKey('submit')) {
            return shape('errors' => Vector {}, 'model' => null, 'success' => false);
        }

        $model  = await $modelBuilder($post);
        $errors = await $validator->validate($model);

        if ($errors->isEmpty()) {
            await $successCallback($model);
        }

        return shape('errors' => $errors, 'model' => $model, 'success' => $errors->isEmpty());
    }
}
