<?php
/**
 * Declares Fotolia_Core_API
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/api.php
 */

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Provides Fotolia_Core_API
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/api.php
 */
abstract class Fotolia_Core_API extends Fotolia
{


  /**
   * Load the Fotolia API object definition
   *
   * @return NULL
   *
   * @throws Fotolia_Exception Can't load Fotolia API.
   */
  protected function _load_fotolia_api()
  {
    if ( ! class_exists('FotoliaApi', FALSE))
    {
      $fotolia_api_file = Kohana::find_file('vendor', 'Fotolia-API/php/fotolia-api');

      if ($fotolia_api_file === FALSE)
      {
        throw new Fotolia_Exception(
          __('Can\'t load Fotolia API.')
        );
      }

      $file = file_get_contents($fotolia_api_file);
      $file = preg_replace('/Fotolia_Api/', 'FotoliaApi', $file);
      $file = preg_replace('/<\?php/', '', $file);

      eval($file);
    }
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
    $this->_load_fotolia_api();

    return array();
  }

} // End Fotolia_Core_API