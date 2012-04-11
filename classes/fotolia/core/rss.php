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
  const METHOD = 'RSS';        /** Method (used to read configuration) */

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
   * @param string $set set to use
   *
   * @return Fotolia
   */
  protected function __construct($set)
  {
    parent::__construct($set);

    $this->_reset_params();
  }

  /**
   * Execute a RSS request to the fotolia picture library
   *
   * @param string $url RSS URL
   *
   * @return string RSS stream
   */
  protected function _execute_request($url)
  {
    return self::parse_rss($url);
  }


  /**
   * Parse a RSS stream for normalised results
   *
   * @param array $rss RSS items
   *
   * @return array results
   */
  protected function _parse_results(array $rss)
  {
    $items = array();

    if (array_key_exists('RSS', $rss)
        and array_key_exists('CHANNEL', $rss['RSS'])
        and array_key_exists('ITEM', $rss['RSS']['CHANNEL'])
        and is_array($rss['RSS']['CHANNEL']['ITEM']))
    {
      foreach ($rss['RSS']['CHANNEL']['ITEM'] as $item)
      {
        $items[] = array(
          'title' => $item['TITLE'],
          'link'  => $item['LINK'],
          'image' => $item['DESCRIPTION'],
        );
      }
    }

    return $items;
  }


  /**
   * Prepare the RSS URL to query the Fotolia picture library for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return string RSS URI
   */
  protected function _prepare_request_url($keywords = '')
  {
    $url = 'http://rss.fotolia.com?';

    $this->param('k', $keywords);

    return $url.$this->_uri_params();
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
    $this->_params = $this->config['params'];
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
   * @param string $set    set to use
   *
   * @return NULL
   *
   * @throws Fotolia_Exception
   */
  public static function factory($method, $set = 'default')
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
   * Fetch a RSS feed
   *
   * @param string $url URL of the RSS feed
   *
   * @return array list of results
   *
   * @see http://www.stemkoski.com/how-to-easily-parse-a-rss-feed-with-php-4-or-php-5/
   */
  public static function parse_rss($url)
  {
    $feedeed = implode('', file($url));
    $parser  = xml_parser_create();

    xml_parse_into_struct($parser, $feedeed, $valueals);
    xml_parser_free($parser);

    foreach ($valueals as $keyey => $valueal)
    {
      if ($valueal['type'] != 'cdata')
      {
        $item[$keyey] = $valueal;
      }
    }

    $i = 0;

    foreach ($item as $value)
    {
      if ($value['type'] == 'open')
      {
        $i++;
        $itemame[$i] = $value['tag'];
      }
      elseif ($value['type'] == 'close')
      {
        $feed = $values[$i];
        $item = $itemame[$i];
        $i--;

        if (array_key_exists($i, $values)
            and count($values[$i])>1)
        {
          $values[$i][$item][] = $feed;
        }
        else
        {
          $values[$i][$item] = $feed;
        }
      }
      else
      {
        $values[$i][$value['tag']] = $value['value'];
      }
    }

    return $values[0];
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
    $url = $this->_prepare_request_url($keywords);

    $rss = $this->_execute_request($url);

    return $this->_parse_results($rss);
  }

} // End Fotolia_Core_RSS