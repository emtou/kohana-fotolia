<?php
/**
 * Declares Fotolia_Core
 *
 * PHP version 5
 *
 * @group fotolia
 *
 * @category  Fotolia
 * @package   Fotolia
 * @author    mtou <mtou@charougna.com>
 * @copyright 2012 mtou
 * @license   http://www.debian.org/misc/bsd.license BSD License (3 Clause)
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core.php
 */

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Provides Fotolia_Core
 *
 * PHP version 5
 *
 * @group fotolia
 *
 * @category  Fotolia
 * @package   Fotolia
 * @author    mtou <mtou@charougna.com>
 * @copyright 2012 mtou
 * @license   http://www.debian.org/misc/bsd.license BSD License (3 Clause)
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core.php
 */
abstract class Fotolia_Core
{
  public $config = NULL;          /** Configuration (from file) */


  /**
   * Creates and initialises a Fotolia instance
   *
   * Can't be called, the factory() method must be used.
   *
   * @return Fotolia
   */
  protected function __construct()
  {
    // Load configuration from file
    ($this->config === NULL) and $this->config = Kohana::$config->load('fotolia');
  }


  /**
   * Create a chainable instance of a Fotolia object
   *
   * @param string $method Fotolia interaction method (API or RSS)
   *
   * @return Fotolia
   *
   * @throws Fotolia_Exception Fotolia interaction method :method not handled.
   */
  public static function factory($method)
  {
    $class_name = 'Fotolia_'.$method;

    if ( ! class_exists($class_name))
    {
      throw new Fotolia_Exception(
        __('Fotolia interaction method :method not handled.', array(':method' => $method))
      );
    }

    return new $class_name;
  }

} // End class Fotolia_Core