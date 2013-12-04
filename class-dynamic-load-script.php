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
 * Dynamic Load Script.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package Dynamic_Load
 * @author  Matias Esteban <estebanmatias92@gmail.com>
 */
class Dynamic_Load_Script extends Dynamic_Load {

    /**
     * [$asset description]
     *
     * @var string
     */
    protected $asset = 'js';

    /**
     * [$handle description]
     *
     * @var string
     */
    protected $handle = 'name';

    /**
     * [$src description]
     *
     * @var string
     */
    protected $src = '';

    /**
     * [$deps description]
     *
     * @var array
     */
    protected $deps = array();

    /**
     * [$version description]
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * [$in_footer description]
     *
     * @var boolean
     */
    protected $in_footer = false;

    /**
     * [$registered description]
     *
     * @var [type]
     */
    protected $registered = false;

    /**
     * [__construct description]
     *
     * @since [version]
     *
     * @param string    $handle     [description]
     * @param string    $path       [description]
     * @param array     $deps       [description]
     * @param boolean   $in_footer  [description]
     * @param boolean   $registered [description]
     */
    public function __construct( $handle, $path, $deps = array(), $in_footer = true, $registered = false ) {

        $this->root_path  = trailingslashit( $path );

        $this->handle     = $handle;
        $this->deps       = $deps;
        $this->in_footer  = $in_footer;
        $this->registered = $registered;

    }

    /**
     * [enqueue_script description]
     *
     * @since  [version]
     *
     * @return [type]    [description]
     */
    public function enqueue_script() {

        if ( ! $this->get_asset_data() )
            return;

        if ( $this->registered == true)
            wp_deregister_script( $this->handle );

        wp_register_script( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );
        wp_enqueue_script( $this->handle );

        //wp_enqueue_script($this->handle, $this->src, $this->deps, $this->version, $this->in_footer ); // fast way

    }

    /**
     * [get_asset_data description]
     *
     * @since  [version]
     *
     * @return [type]    [description]
     */
    protected function get_asset_data() {

        if ( ! $this->get_json_object() )
            return false;

        // find and get script data in the json object
        foreach ( $this->json_object[$this->asset] as $library ) {

            if ( empty( $library['name'] ) || empty( $library['urls'] ) || in_array( "", $library['urls'] ) )
                return false;


            if ( $library['name'] == $this->handle ) {

                //$load = new Dynamic_Load();

                $this->src     = $this->select_URL( $library['urls'] );
                $this->version = $library['version'];

                return true;

            }

        }

        return false;

    }

    /**
     * [load description]
     *
     * @since  [version]
     *
     * @param  array     $actions      [description]
     * @param  integer   $priority     [description]
     *
     * @return [type]    [description]
     */
    public function load( $actions = array( 'wp' ), $priority = 10 ) {

        foreach ( $actions as $action ) {
            $action = $action . '_enqueue_scripts';
            add_action( $action, array( $this, 'enqueue_script' ), $priority );
        }

    }

}
