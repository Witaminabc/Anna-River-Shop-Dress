<?php

// Виджет Кнопка Сбросить все фильтры
function rs_reset_filter_widget() {
    register_widget( 'RS_WC_Widget_Reset_button' );
}

add_action( 'widgets_init', 'rs_reset_filter_widget' );
class RS_WC_Widget_Reset_button extends WC_Widget {
    public function __construct() {
        $this->widget_cssclass    = 'woocommerce widget_layered_nav woocommerce-widget-layered-nav';
        $this->widget_description = __( 'RS Кнопка Сбросить все фильтры', 'woocommerce' );
        $this->widget_id          = 'rs_woocommerce_reset_button';
        $this->widget_name        = 'RS Сбросить все фильтры';
        parent::__construct();
    }
    /**
     * Updates a particular instance of a widget.
     *
     * @see WP_Widget->update
     *
     * @param array $new_instance New Instance.
     * @param array $old_instance Old Instance.
     *
     * @return array
     */
    public function update( $new_instance, $old_instance ) {
        $this->init_settings();
        return parent::update( $new_instance, $old_instance );
    }
    /**
     * Outputs the settings update form.
     *
     * @see WP_Widget->form
     *
     * @param array $instance Instance.
     */
    public function form( $instance ) {
        $this->init_settings();
        parent::form( $instance );
    }
    /**
     * Init settings after post types are registered.
     */
    public function init_settings() {
        $this->settings  = array(
            'title' => array(
                'type'  => 'text',
                'std'   => __( 'Сбросить все фильтры', 'woocommerce' ),
                'label' => __( 'Title', 'woocommerce' ),
            ),
        );
    }
    /**
     * Output widget.
     *
     * @see WP_Widget
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     */
    public function widget( $args, $instance ) {
        //global $products;
        if ( ! is_shop() && ! is_product_taxonomy() ) {
            return;
        }
        $buttonTxt=$instance['title'];
        $get_terms_args = array( 'hide_empty' => '1' );
        $this->widget_start( $args, $instance );

        $url = $this->get_current_page_url();
        $fin = explode('?', $url)[0];

        echo '<div class="action-control">';
        echo '<a class="btn btn-reset btn-default" rel="nofollow" href="' .  $fin . '">' . $buttonTxt. '</a> ';
        echo '</div>';
        $this->widget_end( $args );
    }
}