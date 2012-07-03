<?php
/**
 * Declares Fotolia_Core_Collection
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/collection.php
 */

defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Provides Fotolia_Core_Collection
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/classes/fotolia/core/collection.php
 */
abstract class Fotolia_Core_Collection implements Iterator, Countable, SeekableIterator, ArrayAccess
{
  protected $_items    = NULL; /** Items in the collection */
  protected $_iterator = NULL; /** Iterator on the items */

  public $max_items = -1;      /** maximum retrievable number of items */


  /**
   * Init the internal collection and its iterator
   *
   * @return Fotolia_Collection
   */
  public function __construct()
  {
    $this->_items    = new ArrayObject;
    $this->_iterator = $this->_items->getIterator();
  }


  /**
   * Append a Fotolia_Result instance to the collection
   *
   * Chainable method.
   *
   * @param Model_Fotolia_Result $item item to append
   *
   * @return Fotolia_Collection
   */
  public function append(Model_Fotolia_Result $item)
  {
    $this->_items->append($item);
  }


  /**
   * Implementation of the Iterator interface
   *
   * @return Fotolia_Collection
   */
  public function rewind()
  {
    $this->_iterator->rewind();
    return $this;
  }

  /**
   * Implementation of the Iterator interface
   *
   * @return Model_Fotolia_Result|NULL
   */
  public function current()
  {
    if ($this->_iterator->count())
      return $this->_iterator->current();

    return NULL;
  }

  /**
   * Implementation of the Iterator interface
   *
   * @return int
   */
  public function key()
  {
    return $this->_iterator->key();
  }

  /**
   * Implementation of the Iterator interface
   *
   * @return Fotolia_Collection
   */
  public function next()
  {
    $this->_iterator->next();

    return $this;
  }

  /**
   * Implementation of the Iterator interface
   *
   * @return bool
   */
  public function valid()
  {
    return $this->_iterator->valid();
  }

  /**
   * Implementation of the Countable interface
   *
   * @return int
   */
  public function count()
  {
    return $this->_iterator->count();
  }

  /**
   * Implementation of SeekableIterator
   *
   * @param mixed $offset offset
   *
   * @return boolean
   */
  public function seek($offset)
  {
    return $this->_iterator->seek($offset);
  }

  /**
   * ArrayAccess: offsetExists
   *
   * @param mixed $offset offset
   *
   * @return bool
   */
  public function offsetExists($offset)
  {
    return $this->_iterator->offsetExists($offset);
  }

  /**
   * ArrayAccess: offsetGet
   *
   * @param mixed $offset offset
   *
   * @return  Model_Fotolia_Result
   */
  public function offsetGet($offset)
  {
    return $this->_iterator->offsetGet($offset);
  }

  /**
   * ArrayAccess: offsetSet
   *
   * @param mixed $offset offset
   * @param mixed $value  value
   *
   * @return  void
   */
  final public function offsetSet($offset, $value)
  {
    return $this->_iterator->offsetGet($offset, $value);
  }

  /**
   * ArrayAccess: offsetUnset
   *
   * @param mixed $offset offset
   *
   * @return void
   */
  final public function offsetUnset($offset)
  {
    return $this->_iterator->offsetUnset($offset);
  }

} // End Fotolia_Core_Collection