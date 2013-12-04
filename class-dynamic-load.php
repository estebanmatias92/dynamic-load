<?php
/**
 * Dynamic Load.
 *
 * @package   Dynamic_Load
 * @author    Matias Esteban <estebanmatias92@gmail.com>
 * @license   MIT License
 * @link      http://example.com
 * @copyright 2013 Matias Esteban
 */

/**
 * Dynamic Load.
 *
 * Load assets as js and css dynamically, uses a json file, with the asset slug, and the CDN url to find it.
 *
 * @package Dynamic_Load
 * @author  Matias Esteban <estebanmatias92@gmail.com>
 */
class Dynamic_Load {

    /**
     * [$json_file description]
     *
     * @var string
     */
    protected $json_file = 'config-assets.json';

    /**
     * [$json_object description]
     *
     * @var [type]
     */
    protected $json_object = null;

    /**
     * [$root_path description]
     *
     * @var string
     */
    protected $root_path = '';

    /**
     * check_URL checks through sockets and header if url exist and is online.
     *
     * @since  1.0.0
     *
     * @param  string    $url          $url contains the url in a string.
     *
     * @return boolean   If url exist and it's online return true, else return false.
     */
    public function check_URL( $url ) {

        if($url == NULL) return false;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $httpcode>=200 && $httpcode<300 ? true : false;

    }

    /**
     * [get_json_object description]
     *
     * @since  [version]
     *
     * @return [type]    [description]
     */
    protected function get_json_object() {

        // set the json file path
        $this->set_json_path();

        // search the json file
        if (  file_get_contents( $this->json_file ) === false )
            return false;

        // read the file and save it in a variable
        // convert this to string
        $str_datos   = file_get_contents( $this->json_file );
        $json_object = json_decode( $str_datos, true ) ;

        // if find it, return true
        if ( ! empty( $json_object ) ) {

            $this->json_object = $json_object;

            return true;

        }

        return false;

    }

    /**
     * [select_URL description]
     *
     * @since  [version]
     *
     * @param  array     $urls         [description]
     *
     * @return [type]    [description]
     */
    public function select_URL( $urls = array() ) {

        foreach ( $urls as $url ) {

            // if url hasn't a http: or https: element, will be assigned
            // if is local url, (not contains domain: domain.com), the site url will be assigned
            if ( stripos( $url, 'http://' ) === false && stripos( $url, 'https://' ) === false ) {

                $url = ( stripos( $url, "//" ) !== false ? 'https:' : $this->root_path ) . $url;

            }

            // return url if its online
            if ( $this->check_URL( $url ) ) {
                return $url;
            }

        }

        return false;

    }

    /**
     * [set_json_path description]
     *
     * @since [version]
     */
    protected function set_json_path() {

        $this->json_file = $this->root_path . $this->json_file;

    }

}
