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
  const METHOD_API = 'api';
  const METHOD_RSS = 'rss';

  protected $_method = NULL;

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
   * Load the Fotolia API object definition
   *
   * @return NULL
   *
   * @throws Fotolia_Exception Can't load Fotolia API.
   */
  protected function _load_fotolia_api()
  {
    if ( ! class_exists('Fotolia_Api', FALSE))
    {
      $fotolia_api_file = Kohana::find_file('vendor', 'Fotolia-API/php/fotolia-api');

      if ($fotolia_api_file === FALSE)
      {
        throw new Fotolia_Exception(
          __('Can\'t load Fotolia API.')
        );
      }

      include $fotolia_api_file;
    }
  }


  /**
   * Searches the Fotolia picture library via the API for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return array list of results
   */
  protected function _search_api($keywords = '')
  {
    $this->_load_fotolia_api();

    return array();
  }


  /**
   * Searches the Fotolia picture library via RSS for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return array list of results
   */
  protected function _search_rss($keywords = '')
  {
    return array();
  }


  /**
   * Create a chainable instance of a Fotolia object
   *
   * @return Fotolia
   */
  public static function factory()
  {
    return new Fotolia;
  }


  /**
   * Gets or sets the method to interact with the Fotolia API
   *
   * Chainable method (in set mode)
   *
   * @param string $method method (in set mode)
   *
   * @return string|Fotolia method (in get mode) or this
   */
  public function method($method = NULL)
  {
    if (is_null($method))
    {
      if ( ! is_null($this->_method))
        return $this->_method;

      if ( ! is_null($this->config->get('method')))
        return $this->config['method'];

      return Fotolia::METHOD_RSS;
    }

    $this->_method = $method;

    return $this;
  }


  /**
   * Searches the Fotolia picture library for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return array list of results
   *
   * @throws Fotolia_Exception Can't handle search method :method.
   */
  public function search($keywords = '')
  {
    $method_name = '_search_'.strtolower($this->method());
    if ( ! method_exists($this, $method_name))
    {
      throw new Fotolia_Exception(
        __('Can\'t handle search method :method.', array(':method' => $this->method()))
      );
    }

    return call_user_func(array($this, $method_name), $keywords);
  }

} // End class Fotolia_Core