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
 * Dynamic Load Style.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package Dynamic_Load_Script
 * @author  Matias Esteban <estebanmatias92@gmail.com>
 */
class Dynamic_Load_Style extends Dynamic_Load_Script {

    /**
     * [$asset description]
     *
     * @var string
     */
    protected $asset = 'css';

    /**
     * [$condition description]
     *
     * @var string
     */
    private $condition = '';

    /**
     * [$media description]
     *
     * @var string
     */
    protected $media = '';

    /**
     * [__construct description]
     *
     * @since [version]
     *
     * @param string    $handle     [description]
     * @param string    $path       [description]
     * @param array     $deps       [description]
     * @param string    $media      [description]
     * @param boolean   $registered [description]
     */
    public function __construct( $handle, $path, $deps = array(), $media = 'all', $registered = false ) {

        $this->root_path  = trailingslashit( $path );

        $this->handle     = $handle;
        $this->deps       = $deps;
        $this->media      = $media;
        $this->registered = $registered;

    }

    /**
     * [enqueue_style description]
     *
     * @since  [version]
     *
     * @return [type]    [description]
     */
    public function enqueue_style() {

        // call regitered list styles
        global $wp_styles;

        if ( ! $this->get_asset_data() )
            return;

        // if have stated how registered, will overwrite
        if ( $this->registered == true)
            wp_deregister_style( $this->handle );

        wp_register_style( $this->handle, $this->src, $this->deps, $this->version, $this->in_footer );

        // if have set conditions, these will apply
        if ( ! empty( $this->condition ) )
            $wp_styles->add_data( $this->handle, 'conditional', $this->condition );

        wp_enqueue_style( $this->handle );

        //wp_enqueue_style($this->handle, $this->src, $this->deps, $this->version, $this->in_footer ); // fast way

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
            add_action( $action, array( $this, 'enqueue_style' ), $priority );
        }

    }

    /**
     * [set_condition description]
     *
     * @since [version]
     *
     * @param string    $condition [description]
     */
    public function set_condition( $condition ) {

        $this->condition = $condition;

    }

}
