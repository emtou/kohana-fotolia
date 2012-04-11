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
  const METHOD = 'NOTSET';        /** Method (used to read configuration) */

  protected $_search_params         = array(); /** search params */
  protected $_default_search_params = array(); /** default search params (need overloading) */

  public $config = NULL;          /** Configuration (from file) */


  /**
   * Creates and initialises a Fotolia instance
   *
   * Can't be called, the factory() method must be used.
   *
   * @param string $set set to use
   *
   * @return Fotolia
   */
  protected function __construct($set)
  {
    // Load configuration from file
    ($this->config === NULL) and $this->config = Kohana::$config->load('fotolia')->get(strtolower($this::METHOD))[$set];

    $this->_reset_search_params();
  }


  /**
   * Create a chainable instance of a Fotolia object
   *
   * @param string $method Fotolia interaction method (API or RSS)
   * @param string $set    set to use
   *
   * @return Fotolia
   *
   * @throws Fotolia_Exception Fotolia interaction method :method not handled.
   */
  public static function factory($method, $set = 'default')
  {
    $class_name = 'Fotolia_'.$method;

    if ( ! class_exists($class_name))
    {
      throw new Fotolia_Exception(
        'Fotolia interaction method :method not handled.',
        array(':method' => $method)
      );
    }

    return new $class_name($set);
  }


  /**
   * Return prepared search params
   *
   * @return array prepared search params
   */
  protected function _prepare_search_params()
  {
    $params = array();

    foreach ($this->_search_params as $alias => $value)
    {
      if ( ! array_key_exists($alias, $this->_default_search_params))
      {
        throw new Fotolia_Exception(
          'Parameter :alias not handled.',
          array(':alias', $alias)
        );
      }

      if ($value != $this->_default_search_params[$alias]
          and ! is_null($value))
      {
        $params[$alias] = $value;
      }
    }

    return $params;
  }


  /**
   * Resets the search params from configuration
   *
   * Chainable method
   *
   * @return Fotolia
   */
  protected function _reset_search_params()
  {
    $this->_search_params = $this->config['search_params'];
  }


  /**
   * Get or set a search parameter
   *
   * Chainable method.
   *
   * @param string $alias alias of the param
   * @param mixed  $value optional value of the param (in set mode)
   *
   * @return mixed|Fotolia value of the param (in set mode) or this
   *
   * @throws Fotolia_Exception Search param :alias does not exist.
   */
  public function search_param($alias, $value = NULL)
  {
    if ( ! is_null($value))
    {
      $this->_search_params[$alias] = $value;
      return $this;
    }

    if ( ! array_key_exists($alias, $this->_search_params))
    {
      throw new Fotolia_Exception(
        'Search param :alias does not exist.',
        array(':alias' => $alias)
      );
    }

    return $this->_search_params[$alias];
  }

} // End class Fotolia_Core