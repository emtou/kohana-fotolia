<?php
/**
 * Declares Fotolia default configuration
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
 * @link      https://github.com/emtou/kohana-fotolia/tree/master/config/fotolia.php
 */

defined('SYSPATH') OR die('No direct access allowed.');

return array(
  'rss' => array(

    /** default set */
    'default' => array(
      'search_params' => array(
        /**
        * Alias         : start
        * Type          : Integer >=0
        * Default value : 0
        * Description   : Première position de la recherche (utile à la navigation page par page)
        * Example       : start=0
        */
        'start' => 0,

        /**
        * Alias         : limit
        * Type          : 0 < Integer <200
        * Default value : 30
        * Nombre d’images à retourner
        * Example       : limit=20
        */
        'limit' => 30,

        /**
        * Alias         : k
        * Type          : varchar (encode for url)
        * Description   : Mot clé (il est possible d’avoir plusieurs mots clés séparés par un espace)
        *                 par exemple k=chien%20animal
        * Example       : k=chien
        */
        'k' => '',

        /**
        * Alias         : p
        * Type          : Integer > 0
        * Description   : ID du photographe permettant de limiter la recherche à un portfolio donné
        */
        'p' => '',

        /**
        * Alias         : size
        * Type          : 30 : fixed height 30px
        *                 110 : 110px (better)
        *                 140 : fixed height 140px
        *                 300
        * Default value : 30
        * Description   : Taille de l’aperçu affiché. Nous recommandons d’utiliser des aperçus de 110 pixels.
        * Example       : size=110
        */
        'size' => 30,

        /**
        * Alias         : IDZone
        * Type          : 1 : Site Français
        *                 2 : Site Américain
        *                 3 : Site Anglais
        *                 4 : Site Allemand
        *                 5 : Site Espagnol
        *                 6 : Site Italien
        *                 7 : Site Portugais
        *                 8 : Site Brésilien
        * Default value : 2
        * Description   : La zone indique dans quelle langue la requête sera effectuée
        *                 et sur quel site l’utilisateur sera redirigé en cliquant sur une image.
        * Example       : IDZone=2
        */
        'IDZone' => 2,

        /**
        * Alias         : orderbydate
        * Type          : 0 : ordonne par pertinence
        *                 1 : ordonne par date
        * Default value : 0
        * Description   : Si orderbydate=1, la recherche sera ordonnée par image les plus récentes
        * Example       : orderbydate=0
        */
        'orderbydate' => 0,

        /**
        * Alias         : partner
        * Type          : Integer > 0
        * Description   : L’ID partner représente votre ID sur Fotolia (voir “Mon profil”).
        *                 Si vous entrez ce paramètre, vous pourrez affilier vos visiteurs.
        * Example       : partner=1
        */
        'partner' => '',
      ),
    ), /** end RSS default set */

    /**
    'other_rss_set' => array(
      'params' => array(
        // ...
      ),
    ),
    */

  ), /** End RSS sets */

  'api' => array(
    'default' => array(
      /** Fotolia API key */
      'api_key'       => NULL,

      'search_params' => array(
        /**
         * Alias        : language_id
         * Type         : Int
         * Valid values : 1  => French
         *                2  => American
         *                3  => English
         *                4  => German
         *                5  => Spanish
         *                6  => Italian
         *                7  => Portuguese
         *                8  => Brazilian
         *                9  => Japanese
         *                11 => Polish
         *                12 => Russian
         *                13 => Chinese
         *                14 => Turkish
         *                15 => Korean
         * Default value: 2
         */
        'language_id' => 2,

        /**
         * Alias        : words
         * Type         : string
         * Valid values : list of words
         * Default value: none
         * Detail       : keyword search
         *                words can also be media_id using # to search for some media ( ex : #20 #21 #22)
         */
        'words' => NULL,

        /**
         * Alias        : creator_id
         * Type         : int
         * Valid values : valid creator id
         * Default value: none
         * Detail       : Search by creator
         */
        'creator_id' => NULL,

        /**
         * Alias        : cat1_id
         * Type         : int
         * Valid values : valid category1 id
         * Default value: none
         * Detail       : Search by representative category
         *                get valid categories1 ids width getCategories1
         */
        'cat1_id' => NULL,

        /**
         * Alias        : cat2_id
         * Type         : int
         * Valid values : valid category2 id
         * Default value: none
         * Detail       : Search by conceptual category
         *                get valid valid category2 id's width getCategories2
         */
        'cat2_id' => NULL,

        /**
         * Alias        : gallery_id
         * Type         : int
         * Valid values : valid gallery id
         * Default value: none
         * Detail       : Search by gallery
         *                get valid galleries id's with getGalleries
         */
        'gallery_id' => NULL,

        /**
         * Alias        : country_id
         * Type         : int
         * Valid values : valid country id
         * Default value: none
         * Detail       : Search by country
         *                get valid country id's with getCountries
         */
        'country_id' => NULL,

        /**
         * Alias        : media_id
         * Type         : int
         * Valid values : existing media id
         * Default value: none
         * Detail       : Search by media id
         */
        'media_id' => NULL,

        /**
         * Alias        : model_id
         * Type         : int
         * Valid values : existing media id
         * Default value: none
         * Detail       : Search by same model
         */
        'model_id' => NULL,

        /**
         * Alias        : serie_id
         * Type         : int
         * Valid values : existing media id
         * Default value: none
         * Detail       : Search by same serie
         */
        'serie_id' => NULL,

        /**
         * Alias        : similia_id
         * Type         : int
         * Valid values : existing media id
         * Default value: none
         * Detail       : Search by similar media (similia)
         */
        'similia_id' => NULL,

        /**
         * Alias        : filters.content_type:photo
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Search for photos
         */
        'filters.content_type:photo' => 0,

        /**
         * Alias        : filters.content_type:illustration
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Search for illustrations
         */
        'filters.content_type:illustration' => 0,

        /**
         * Alias        : filters.content_type:vector
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Search for vectors
         */
        'filters.content_type:vector' => 0,

        /**
         * Alias        : filters.content_type:video
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Search for videos
         */
        'filters.content_type:video' => 0,

        /**
         * Alias        : filters.content_type:all
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 1
         * Detail       : Search for all files (default)
         */
        'filters.content_type:all' => 1,

        /**
         * Alias        : filters.offensive:2
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Explicit/Charm/Nudity/Violence included
         */
        'filters.offensive:2' => 0,

        /**
         * Alias        : filters.isolated:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Isolated contents
         */
        'filters.isolated:on' => 0,

        /**
         * Alias        : filters.panoramic:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Panoramic images
         */
        'filters.panoramic:on' => 0,

        /**
         * Alias        : filters.license_L:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : L size available
         */
        'filters.license_L:on' => 0,

        /**
         * Alias        : filters.license_XL:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : XL size available
         */
        'filters.license_XL:on' => 0,

        /**
         * Alias        : filters.license_XXL:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : XXL size available
         */
        'filters.license_XXL:on' => 0,

        /**
         * Alias        : filters.license_V_HD1080:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Full HD video size available
         */
        'filters.license_V_HD1080:on' => 0,

        /**
         * Alias        : filters.license_V_HD720:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : HD ready video size available
         */
        'filters.license_V_HD720:on' => 0,

        /**
         * Alias        : filters.license_X:on
         * Type         : int
         * Valid values : 0 - 1
         * Default value: 0
         * Detail       : Extended license available
         */
        'filters.license_X:on' => 0,

        /**
         * Alias        : filters.orientation
         * Type         : string
         * Valid values : horizontal => only horizontal image
         *                vertical   => only vertical image
         *                all        => all images (default)
         * Default value: all
         */
        'filters.orientation' => 'all',

        /**
         * Alias        : filters.age
         * Type         : string
         * Valid values : 1w  => only images 1 week old
         *                1m  => only images 1 month old
         *                6m  => only images 6 months old
         *                1y  => only images 1 year old
         *                2y  => only images 2 year old
         *                all => all images (default)
         * Default value: all
         */
        'filters.age' => 'all',

        /**
         * Alias        : filters.video_duration
         * Type         : string
         * Valid values : 0   => 0 - 10 seconds
         *                10  => 10 - 20 seconds
         *                20  => 20 - 30 seconds
         *                30  => more than 30 seconds
         *                all => all videos (default)
         * Default value: all
         */
        'filters.video_duration' => 'all',

        /**
         * Alias        : filters.max_price_xs
         * Type         : int
         * Valid values : 1   => XS price = 1
         *                2   => XS price <= 2
         *                all => all prices (default)
         * Default value: all
         */
        'filters.max_price_xs' => 'all',

        /**
         * Alias        : filters.max_price_x
         * Type         : int
         * Detail       : X price <= value you defined
         */
        'filters.max_price_x' => NULL,

        /**
         * Alias        : filters.colors
         * Type         : string
         * Detail       : comma separated listed of hexadecimal colors (without any # prefix)
         */
        'filters.colors' => NULL,

        /**
         * Alias        : order
         * Type         : string
         * Valid values : relevance    => Relevance
         *                price_1      => price ASC
         *                creation     => creation date DESC
         *                nb_views     => number of views DESC
         *                nb_downloads => number of downloads DESC
         * Default value: relevance
         */
        'order' => 'relevance',

        /**
         * Alias        : limit
         * Type         : Int
         * Valid values : 1 to 64
         * Default value: 32
         * Detail       : maximum number of media returned
         */
        'limit' => 32,

        /**
         * Alias        : offset
         * Type         : int
         * Valid values : 0 to max results
         * Default value: 0
         * Detail       : Start position in query
         */
        'offset' => 0,

        /**
         * Alias        : thumbnail_size
         * Type         : int
         * Valid values : 30  => Small (30px)
         *                110 => Medium (110px)
         *                400 => Large (400px - watermarked)
         * Default value: 110
         */
        'thumbnail_size' => 110,

        /**
         * Alias        : detail_level
         * Type         : int
         * Valid values : 1
         * Default value: none
         * Detail       : When this parameter is sent and set to 1, the method will return for each content :
         *                - nb_downloads
         *                - nb_views
         */
        'detail_level' => NULL,

        /**
         * Alias        : result_columns
         * Type         : array with keys :
         *                - nb_results
         *                - id
         *                - title
         *                - creator_name
         *                - creator_id
         *                - thumbnail_url
         *                - thumbnail_html_tag
         *                - thumbnail_width
         *                - thumbnail_height
         *                - affiliation_link
         *                - thumbnail_30_url
         *                - thumbnail_30_width
         *                - thumbnail_30_height
         *                - thumbnail_110_url
         *                - thumbnail_110_width
         *                - thumbnail_110_height
         *                - thumbnail_400_url
         *                - thumbnail_400_width
         *                - thumbnail_400_height
         *                - flv_url
         *                - media_type_id
         *                - cat1
         *                - cat1_hierarchy
         *                - cat2
         *                - cat2_hierarchy
         *                - nb_views
         *                - nb_downloads
         *                - creation_date
         *                - keywords
         *                - licenses
         *                - available_for_subscription
         * Valid values : One of more items of this list
         * Default value: - nb_results
         *                - id
         *                - title
         *                - creator_name
         *                - creator_id
         *                - thumbnail_url
         *                - thumbnail_html_tag
         *                - thumbnail_width
         *                - thumbnail_height
         *                - affiliation_link
         *                - thumbnail_110_url
         *                - thumbnail_110_width
         *                - thumbnail_110_height
         *                - creation_date
         *                - media_type_id
         *                - flv_url
         *                - licenses
         * Detail       : Fields you want to have included in the answer
         */
        'result_columns' => array(
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
      ),
    ), /** end API default set

    /**
    'other_api_set' => array(
      'params' => array(
        // ...
      ),
    ),
    */

  ), /** End API sets */
);