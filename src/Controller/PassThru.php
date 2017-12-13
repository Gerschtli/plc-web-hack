<?hh // strict

namespace PLC\Controller;

use Viewable;

/**
 * PassThru Controller
 *
 * Delegates render call straight to provided view.
 */
class PassThru extends Controller implements Controllable
{}
