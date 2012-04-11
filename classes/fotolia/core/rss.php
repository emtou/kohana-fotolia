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

  /** RSS URI default params */
  protected $_default_search_params = array(
    'start'       => 0,
    'limit'       => 30,
    'k'           => '',
    'p'           => '',
    'size'        => 30,
    'IDZone'      => 2,
    'orderbydate' => 0,
    'partner'     => '',
  );


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
   * Returns a collection with given search results
   *
   * @param array $results search results as given by the Fotolia API
   *
   * @return Fotolia_Collection
   */
  protected function _parse_search_results(array $results)
  {
    $collection = new Fotolia_Collection;

    if (array_key_exists('RSS', $results)
        and array_key_exists('CHANNEL', $results['RSS'])
        and array_key_exists('ITEM', $results['RSS']['CHANNEL'])
        and is_array($results['RSS']['CHANNEL']['ITEM']))
    {
      foreach ($results['RSS']['CHANNEL']['ITEM'] as $result)
      {
        $item = Model::factory('fotolia_result');

        foreach ($result as $key => $value)
        {
          $item->$key = $value;
        }

        $collection->append($item);
      }
    }

    return $collection;
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

    $this->search_param('k', $keywords);

    return $url.implode('&', $this->_prepare_search_params());
  }


  /**
   * Return prepared search params
   *
   * @return array prepared search params
   */
  protected function _prepare_search_params()
  {
    $params = parent::_prepare_search_params();

    foreach ($params as $alias => $value)
    {
      if (is_array($value))
      {
        $value = implode(' ', $value);
      }

      $params[$alias] = urlencode($alias).'='.urlencode($value);
    }

    return $params;
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
      'Direct factory method should never be used.'
    );

    unset($method);
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
   * @param array        $params   search params
   *
   * @return array list of results
   */
  public function search($keywords = '', array $params = array())
  {
    foreach ($params as $alias => $value)
    {
      $this->search_param($alias, $value);
    }

    $url = $this->_prepare_request_url($keywords);

    $rss = $this->_execute_request($url);

    return $this->_parse_search_results($rss);
  }

} // End Fotolia_Core_RSS