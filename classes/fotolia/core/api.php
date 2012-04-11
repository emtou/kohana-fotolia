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
  const METHOD = 'API';        /** Method (used to read configuration) */

  protected $_api = NULL;   /** Fotolia API instance */

  /** search default params */
  protected $_default_search_params = array(
    'language_id'                       => 2,
    'words'                             => NULL,
    'creator_id'                        => NULL,
    'cat1_id'                           => NULL,
    'cat2_id'                           => NULL,
    'gallery_id'                        => NULL,
    'country_id'                        => NULL,
    'media_id'                          => NULL,
    'model_id'                          => NULL,
    'serie_id'                          => NULL,
    'similia_id'                        => NULL,
    'filters.content_type:photo'        => 0,
    'filters.content_type:illustration' => 0,
    'filters.content_type:vector'       => 0,
    'filters.content_type:video'        => 0,
    'filters.content_type:all'          => 1,
    'filters.offensive:2'               => 0,
    'filters.isolated:on'               => 0,
    'filters.panoramic:on'              => 0,
    'filters.license_L:on'              => 0,
    'filters.license_XL:on'             => 0,
    'filters.license_XXL:on'            => 0,
    'filters.license_V_HD1080:on'       => 0,
    'filters.license_V_HD720:on'        => 0,
    'filters.license_X:on'              => 0,
    'filters.orientation'               => 'all',
    'filters.age'                       => 'all',
    'filters.video_duration'            => 'all',
    'filters.max_price_xs'              => 'all',
    'filters.max_price_x'               => NULL,
    'filters.colors'                    => NULL,
    'order'                             => 'relevance',
    'limit'                             => 32,
    'offset'                            => 0,
    'thumbnail_size'                    => 110,
    'detail_level'                      => NULL,
    'result_columns'                    => array(
                                            'nb_results',
                                            'id',
                                            'title',
                                            'creator_name',
                                            'creator_id',
                                            'thumbnail_url',
                                            'thumbnail_html_tag',
                                            'thumbnail_width',
                                            'thumbnail_height',
                                            'affiliation_link',
                                            'thumbnail_110_url',
                                            'thumbnail_110_width',
                                            'thumbnail_110_height',
                                            'creation_date',
                                            'media_type_id',
                                            'flv_url',
                                            'licenses',
                                           ),
  );


  /**
   * Creates and initialises a Fotolia_API instance
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

    $this->_load_fotolia_api();
    $this->_init_fotolia_api();
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
    if ( ! class_exists('FotoliaApi', FALSE))
    {
      $fotolia_api_file = Kohana::find_file('vendor', 'Fotolia-API/php/fotolia-api');

      if ($fotolia_api_file === FALSE)
      {
        throw new Fotolia_Exception(
          'Can\'t load Fotolia API.'
        );
      }

      $file = file_get_contents($fotolia_api_file);
      $file = preg_replace('/Fotolia_Api/', 'FotoliaApi', $file);
      $file = preg_replace('/<\?php/', '', $file);

      eval($file);
    }
  }


  /**
   * Init the internal API instance with the configured key
   *
   * Chainable method.
   *
   * @return NULL
   */
  protected function _init_fotolia_api()
  {
    $this->init_fotolia_api_with_key($this->config['api_key']);

    return $this;
  }


  /**
   * Init the internal API instance with the given key
   *
   * Chainable method.
   *
   * @param string $api_key current API key
   *
   * @return NULL
   */
  public function init_fotolia_api_with_key($api_key)
  {
    $this->_api = new FotoliaApi($api_key);

    return $this;
  }


  /**
   * Return prepared search params
   *
   * @return array prepared search params
   */
  protected function _prepare_search_params()
  {
    $params = parent::_prepare_search_params();

    $prepared_params = array();

    foreach ($params as $alias => $value)
    {
      if (preg_match('/\./', $alias))
      {
        $subaliases = explode('.', $alias);
        if (count($subaliases) > 2)
        {
          throw new Fotolia_Exception(
            'Can\'t prepare search param :alias with more than 1 sub-level.',
            array(':alias' => $alias)
          );
        }

        if ( ! array_key_exists($subaliases[0], $prepared_params))
        {
          $prepared_params[$subaliases[0]] = array();
        }

        $prepared_params[$subaliases[0]][$subaliases[1]] = $value;
      }
      else
      {
        $prepared_params[$alias] = $value;
      }
    }

    return $prepared_params;
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
    unset($set);
  }


  /**
   * Searches the Fotolia picture library for results matching keywords
   *
   * @param string|array $keywords single keyword or list of keywords
   * @param array        $params   search params
   *
   * @return array list of results
   *
   * @throws Fotolia_Exception Can't handle search method :method.
   */
  public function search($keywords = '', array $params = array())
  {
    foreach ($params as $alias => $value)
    {
      $this->search_param($alias, $value);
    }

    $this->search_param('words', $keywords);

    $params         = $this->_prepare_search_params();
    $result_columns = NULL;

    if (array_key_exists('result_columns', $params))
    {
      $result_columns = $params['result_columns'];
      unset($params['result_columns']);
    }

    $results = $this->get_search_results($params, $result_columns);

    return $this->_parse_search_results($results);
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

    $i = 0;
    while (array_key_exists($i, $results))
    {
      $result = $results[$i];

      $item = Model::factory('fotolia_result');

      foreach ($result as $key => $value)
      {
        $item->$key = $value;
      }

      $collection->append($item);

      ++$i;
    }
    return $collection;
  }


  /**
   * Returns current api key
   *
   * Direct call to the Fotolia API.
   *
   * @return string
   */
  public function get_api_key()
  {
    return $this->_api->getApiKey();
  }


  /**
   * Toggle HTTPS
   *
   * Direct call to the Fotolia API.
   *
   * @param mixed $flag flag
   *
   * @return Fotolia_API this instance
   */
  public function set_https_mode($flag)
  {
    return $this->_api->setHttpsMode($flag);
  }

  /**
   * This method makes possible to search media in fotolia image bank.
   * Full search capabilities are available through the API
   *
   * Direct call to the Fotolia API.
   *
   * @param array $search_params  search params
   * @param array $result_columns if specified, a list a columns you want in the resultset
   *
   * @return array
   */
  public function get_search_results(array $search_params, array $result_columns = NULL)
  {
    return $this->_api->getSearchResults($search_params, $result_columns);
  }

  /**
   * This method returns childs of a parent category in fotolia representative category system.
   * This method could be used to display a part of the category system or the all tree.
   * Fotolia categories system counts three levels.
   *
   * Direct call to the Fotolia API.
   *
   * @param int $language_id language ID
   * @param int $id          ID
   *
   * @return array
   */
  public function get_categories1($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $id = 0)
  {
    return $this->_api->getSearchResults($language_id, $id);
  }

  /**
   * This method returns childs of a parent category in fotolia conceptual category system.
   * This method could be used to display a part of the category system or the all tree.
   * Fotolia categories system counts three levels.
   *
   * Direct call to the Fotolia API.
   *
   * @param int $language_id language ID
   * @param int $id          ID
   *
   * @return array
   */
  public function get_categories2($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $id = 0)
  {
    return $this->_api->getCategories2($language_id, $id);
  }

  /**
   * This method returns most searched tag and most used tag on fotolia website.
   * This method may help you to create a tags cloud.
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $language_id language ID
   * @param string $type        type
   *
   * @return array
   */
  public function get_tags($language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $type = 'Used')
  {
    return $this->_api->getTags($language_id, $type);
  }

  /**
   * This method returns public galleries for a defined language
   *
   * Direct call to the Fotolia API.
   *
   * @param int $language_id language ID
   *
   * @return array
   */
  public function get_galleries($language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
  {
    return $this->_api->getGalleries($language_id);
  }

  /**
   * This method returns Fotolia list of countries.
   *
   * Direct call to the Fotolia API.
   *
   * @param int $language_id language ID
   *
   * @return array
   */
  public function get_countries($language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
  {
    return $this->_api->getCountries($language_id);
  }

  /**
   * This method returns fotolia data
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function get_data()
  {
    return $this->_api->getData();
  }

  /**
   * This method is a test method which returns success if connexion is valid
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function test()
  {
    return $this->_api->test();
  }

  /**
   * This method return all information about a media
   *
   * Direct call to the Fotolia API.
   *
   * @param int $id             ID
   * @param int $thumbnail_size thumbnail size
   * @param int $language_id    language ID
   *
   * @return array
   */
  public function get_media_data($id, $thumbnail_size = 110, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
  {
    return $this->_api->getMediaData($id, $thumbnail_size, $language_id);
  }

  /**
   * This method return all information about a series of media
   *
   * Direct call to the Fotolia API.
   *
   * @param array $ids            IDs
   * @param int   $thumbnail_size thumbnail size
   * @param int   $language_id    language ID
   *
   * @return array
   */
  public function get_bulk_media_data(array $ids, $thumbnail_size = 110, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US)
  {
    return $this->_api->getBulkMediaData($ids, $thumbnail_size, $language_id);
  }

  /**
   * This method return private galleries for logged user
   *
   * Direct call to the Fotolia API.
   *
   * @param int $id             ID
   * @param int $language_id    language ID
   * @param int $thumbnail_size thumbnail size
   *
   * @return array
   */
  public function get_media_galleries($id, $language_id = Fotolia_Api::LANGUAGE_ID_EN_US, $thumbnail_size = 110)
  {
    return $this->_api->getMediaGalleries($id, $language_id, $thumbnail_size);
  }

  /**
   * This method allows to purchase a media and returns url to the purchased file
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $id            ID
   * @param string $license_name  License name
   * @param int    $subaccount_id subaccount ID
   *
   * @return array
   */
  public function get_media($id, $license_name, $subaccount_id = NULL)
  {
    return $this->_api->getMedia($id, $license_name, $subaccount_id);
  }

  /**
   * Download a media and write it to a file if necessary
   *
   * Direct call to the Fotolia API.
   *
   * @param string $download_url URL as returned by getMedia()
   * @param string $output_file  if null the downloaded file will be echoed on standard output
   *
   * @return NULL
   */
  public function download_media($download_url, $output_file = NULL)
  {
    return $this->_api->downloadMedia($download_url, $output_file);
  }

  /**
   * This method returns comp images. Comp images can ONLY be used to evaluate the image
   * as to suitability for a project, obtain client or internal company approvals,
   * or experiment with layout alternatives.
   *
   * Direct call to the Fotolia API.
   *
   * @param int $id ID
   *
   * @return array
   */
  public function get_media_comp($id)
  {
    return $this->_api->getMediaComp($id);
  }

  /**
   * Authenticate an user
   *
   * Direct call to the Fotolia API.
   *
   * @param string $login user login
   * @param string $pass  user password
   *
   * @return NULL
   */
  public function login_user($login, $pass)
  {
    return $this->_api->loginUser($login, $pass);
  }

  /**
   * Log out an user
   *
   * Direct call to the Fotolia API.
   *
   * @return NULL
   */
  public function logout_user()
  {
    return $this->_api->logoutUser();
  }

  /**
   * Create a new Fotolia Member
   *
   * Direct call to the Fotolia API.
   *
   * @param array $properties properties
   *
   * @return int
   */
  public function create_user(array $properties)
  {
    return $this->_api->createUser($properties);
  }

  /**
   * This method returns data for logged user.
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function get_user_data()
  {
    return $this->_api->getUserData();
  }

  /**
   * This method returns sales data for logged user.
   *
   * Direct call to the Fotolia API.
   *
   * @param string $sales_type sales type
   * @param int    $offset     offset
   * @param int    $limit      limit
   * @param int    $id         ID
   * @param string $sales_day  sales day
   *
   * @return array
   */
  public function get_sales_data($sales_type = 'all', $offset = 0, $limit = 50, $id = NULL, $sales_day = NULL)
  {
    return $this->_api->getSalesData($sales_type, $offset, $limit, $id, $sales_day);
  }

  /**
   * This method allows you to get sales/views/income statistics from your account.
   *
   * Direct call to the Fotolia API.
   *
   * @param string $type             type
   * @param string $time_range       time range
   * @param string $easy_date_period easy date period
   * @param string $start_date       start date
   * @param string $end_date         end date
   *
   * @return array
   */
  // @codingStandardsIgnoreStart
  public function get_user_advanced_stats($type, $time_range, $easy_date_period = NULL, $start_date = NULL, $end_date = NULL)
  {
    // @codingStandardsIgnoreEnd
    return $this->_api->getSalesData($type, $time_range, $easy_date_period, $start_date, $end_date);
  }

  /**
   * This methods returns statistics for logged user
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function get_user_stats()
  {
    return $this->_api->getUserStats();
  }

  /**
   * Delete a user's gallery
   *
   * Direct call to the Fotolia API.
   *
   * @param string $id ID
   *
   * @return NULL
   */
  public function delete_user_gallery($id)
  {
    return $this->_api->deleteUserGallery($id);
  }

  /**
   * This method allows you to create a new gallery in your account.
   *
   * Direct call to the Fotolia API.
   *
   * @param string $name name
   *
   * @return array
   */
  public function create_user_gallery($name)
  {
    return $this->_api->createUserGallery($name);
  }

  /**
   * This method allows you to add a content to your default lightbox or any of your existing galleries
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $content_id content ID
   * @param string $id         ID
   *
   * @return array
   */
  public function add_to_user_gallery($content_id, $id = '')
  {
    return $this->_api->addToUserGallery($content_id, $id);
  }

  /**
   * This method allows you to remove a content from your default lightbox or any of your existing galleries
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $content_id content ID
   * @param string $id         ID
   *
   * @return array
   */
  public function remove_from_user_gallery($content_id, $id = '')
  {
    return $this->_api->removeFromUserGallery($content_id, $id);
  }

  /**
   * This method allows to search media in logged user galleries or lightbox.
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $page           page
   * @param int    $per_page       per page
   * @param int    $thumbnail_size thumbnail size
   * @param string $id             ID
   *
   * @return array
   */
  public function get_user_gallery_medias($page = 0, $per_page = 32, $thumbnail_size = 110, $id = '')
  {
    return $this->_api->getUserGalleryMedias($page, $per_page, $thumbnail_size, $id);
  }

  /**
   * This method returns private galleries for logged user.
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function get_user_galleries()
  {
    return $this->_api->getUserGalleries();
  }

  /**
   * This method allows move up media in logged user galleries or lightbox.
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $content_id content ID
   * @param string $id         ID
   *
   * @return NULL
   *
   * @throws Fotolia_Services_Exception
   */
  public function move_up_media_in_user_gallery($content_id, $id = '')
  {
    return $this->_api->moveUpMediaInUserGallery($content_id, $id);
  }

  /**
   * This method allows move down media in logged user galleries or lightbox.
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $content_id content ID
   * @param string $id         ID
   *
   * @return NULL
   *
   * @throws Fotolia_Services_Exception
   */
  public function move_down_media_in_user_gallery($content_id, $id = '')
  {
    return $this->_api->moveDownMediaInUserGallery($content_id, $id);
  }

  /**
   * This method allows move a media to top position in logged user galleries or lightbox.
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $content_id content ID
   * @param string $id         ID
   *
   * @return NULL
   *
   * @throws Fotolia_Services_Exception
   */
  public function move_media_to_top_in_user_gallery($content_id, $id = '')
  {
    return $this->_api->moveMediaToTopInUserGallery($content_id, $id);
  }

  /**
   * Create a new subaccount for the given api key
   *
   * Direct call to the Fotolia API.
   *
   * @param array $subaccount_data subaccount data
   *
   * @return int
   */
  public function subaccount_create($subaccount_data)
  {
    return $this->_api->subaccountCreate($subaccount_data);
  }

  /**
   * Edit a subaccount of the given api key
   *
   * Direct call to the Fotolia API.
   *
   * @param int   $subaccount_id   subaccount ID
   * @param array $subaccount_data subaccount data
   *
   * @return NULL
   */
  public function subaccount_edit($subaccount_id, $subaccount_data)
  {
    return $this->_api->subaccountEdit($subaccount_id, $subaccount_data);
  }

  /**
   * Delete a subaccount of the given api key
   *
   * Direct call to the Fotolia API.
   *
   * @param int $subaccount_id subaccount ID
   *
   * @return NULL
   */
  public function subaccount_delete($subaccount_id)
  {
    return $this->_api->subaccountDelete($subaccount_id);
  }

  /**
   * Returns the ids of all subaccounts of the api key
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function subaccount_get_ids()
  {
    return $this->_api->subaccountGetIds();
  }

  /**
   * Returns details of a given subaccount
   *
   * Direct call to the Fotolia API.
   *
   * @param int $subaccount_id subaccount ID
   *
   * @return array
   */
  public function subaccount_get($subaccount_id)
  {
    return $this->_api->subaccountGet($subaccount_id);
  }

  /**
   * Returns the purchased contents of a given subaccount
   *
   * Direct call to the Fotolia API.
   *
   * @param int $subaccount_id subaccount ID
   * @param int $page          current page number
   * @param int $nb_per_page   number of downloads per page
   *
   * @return array
   */
  public function subaccountget_purchased_contents($subaccount_id, $page = 1, $nb_per_page = 10)
  {
    return $this->_api->subaccountgetPurchasedContents($subaccount_id, $page, $nb_per_page);
  }

  /**
   * Retrieve the content of the shopping cart
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function shoppingcart_get_list()
  {
    return $this->_api->shoppingcartGetList();
  }

  /**
   * Clear the content of the shopping cart
   *
   * Direct call to the Fotolia API.
   *
   * @return array
   */
  public function shoppingcart_clear()
  {
    return $this->_api->shoppingcartClear();
  }

  /**
   * Transfer one or more files from the shopping cart to a lightbox
   *
   * Direct call to the Fotolia API.
   *
   * @param int|array $id ID
   *
   * @return array
   */
  public function shoppingtransfer_to_lightbox($id)
  {
    return $this->_api->shoppingtransferToLightbox($id);
  }

  /**
   * Add a content to the shopping cart
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $id           ID
   * @param string $license_name license name
   *
   * @return array
   */
  public function shoppingcart_add($id, $license_name)
  {
    return $this->_api->shoppingcartAdd($id, $license_name);
  }

  /**
   * Update a content to the shopping cart
   *
   * Direct call to the Fotolia API.
   *
   * @param int    $id           ID
   * @param string $license_name license name
   *
   * @return array
   */
  public function shoppingcart_update($id, $license_name = NULL)
  {
    return $this->_api->shoppingcartUpdate($id, $license_name);
  }

  /**
   * Delete a content from the shopping cart
   *
   * Direct call to the Fotolia API.
   *
   * @param int $id ID
   *
   * @return array
   */
  public function shoppingcart_remove($id)
  {
    return $this->_api->shoppingcartRemove($id);
  }

  /**
   * Returns xml-rpc client
   *
   * Direct call to the Fotolia API.
   *
   * @return Zend_XmlRpc_Client
   */
  public function get_client()
  {
    return $this->_api->getClient();
  }

} // End Fotolia_Core_API