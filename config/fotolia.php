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
      'params' => array(
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
);