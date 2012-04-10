<?php
/**
 * Declares Fotolia_Core_RSS
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/rss.php
 */

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Provides Fotolia_Core_RSS
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/rss.php
 */
abstract class Fotolia_Core_RSS extends Fotolia
{
  protected $_params         = array(); /** RSS URI params */
  protected $_default_params = array(
    'start'       => 0,
    'limit'       => 30,
    'k'           => '',
    'p'           => '',
    'size'        => 30,
    'IDZone'      => 2,
    'orderbydate' => 0,
    'partner'     => '',
  ); /** RSS URI default params */



  /**
   * Creates and initialises a Fotolia_RSS instance
   *
   * Can't be called, the factory() method must be used.
   *
   * @return Fotolia
   */
  protected function __construct()
  {
    parent::__construct();

    $this->_reset_params();
  }

  /**
   * Execute a RSS request to the fotolia picture library
   *
   * @param string $uri RSS URI
   *
   * @return string RSS stream
   */
  protected function _execute_request($uri)
  {
    return '<rss><items></items></rss>';
  }


  /**
   * Parse a RSS stream for normalised results
   *
   * @param string $rss_stream RSS stream
   *
   * @return array results
   */
  protected function _parse_results($rss_stream)
  {
    return array();
  }


  /**
   * Prepare the RSS URL to query the Fotolia picture library for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return string RSS URI
   */
  protected function _prepare_request_uri($keywords = '')
  {
    $uri = 'http://rss.fotolia.com?';

    $this->param('k', $keywords);

    return $uri.$this->_uri_params();
  }


  /**
   * Resets the RSS params from configuration
   *
   * Chainable method
   *
   * @return Fotolia_RSS
   */
  protected function _reset_params()
  {
    $this->_params = $this->config->get('rss')['params'];
  }


  /**
   * Return escaped URI params
   *
   * @return string escaped URI params
   */
  protected function _uri_params()
  {
    $params = array();

    foreach ($this->_params as $alias => $value)
    {
      if ( ! array_key_exists($alias, $this->_default_params))
      {
        throw new Fotolia_Exception(
          __('Parameter :alias not handled.', array(':alias', $alias))
        );
      }

      if ($value != $this->_default_params[$alias])
      {
        if (is_array($value))
        {
          $value = implode(' ', $value);
        }
        $params[] = urlencode($alias).'='.urlencode($value);
      }
    }

    return implode('&', $params);
  }


  /**
   * Overload Fotolia::factory() to disable
   *
   * @param string $method Fotolia interaction method (API or RSS)
   *
   * @return NULL
   *
   * @throws Fotolia_Exception
   */
  public static function factory($method)
  {
    throw new Fotolia_Exception(
      __('Direct factory method should never be used.')
    );

    unset($method);
  }


  /**
   * Get or set a query param
   *
   * Chainable method.
   *
   * @param string $alias alias of the param
   * @param mixed  $value optional value of the param (in set mode)
   *
   * @return mixed|Fotolia_RSS value of the param (in set mode) or this
   *
   * @throws Fotolia_Exception RSS param :alias does not exist.
   */
  public function param($alias, $value = NULL)
  {
    if ( ! is_null($value))
    {
      $this->_params[$alias] = $value;
      return $this;
    }

    if ( ! array_key_exists($alias, $this->_params))
    {
      throw new Fotolia_Exception(
        __('RSS param :alias does not exist.', array(':alias' => $alias))
      );
    }

    return $this->_params[$alias];
  }


  /**
   * Searches the Fotolia picture library via RSS for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return array list of results
   */
  public function search($keywords = '')
  {
    $uri = $this->_prepare_request_uri($keywords);

    $rss = $this->_execute_request($uri);

    return $this->_parse_results($rss);
  }

} // End Fotolia_Core_RSS