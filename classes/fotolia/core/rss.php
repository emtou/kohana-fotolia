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
   * Searches the Fotolia picture library via RSS for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   *
   * @return array list of results
   */
  public function search($keywords = '')
  {
    return array();
  }

} // End Fotolia_Core_RSS