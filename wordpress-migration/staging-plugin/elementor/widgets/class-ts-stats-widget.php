<?php
/**
 * TS Stats Widget for Elementor.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class TS_Stats_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_stats';
    }

    public function get_title() {
        return __( 'TS Stats Strip', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-number-field';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Stats', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'number',
            [
                'label'   => __( 'Number', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '98%', 'tanzania-sensational' ),
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label'   => __( 'Label', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Guest Satisfaction', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'stats',
            [
                'label'       => __( 'Stats', 'tanzania-sensational' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [ 'number' => '98%', 'label' => 'Guest Satisfaction' ],
                    [ 'number' => '15+', 'label' => 'Years of Expertise' ],
                    [ 'number' => '1,500+', 'label' => 'Safaris Operated' ],
                    [ 'number' => '24/7', 'label' => 'In-Country Support' ],
                ],
                'title_field' => '{{{ label }}}',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $stats    = $settings['stats'];

        if ( empty( $stats ) ) {
            return;
        }
        ?>
        <div class="stats">
            <?php foreach ( $stats as $stat ) : ?>
                <div class="stat-item">
                    <div class="stat-num"><?php echo esc_html( $stat['number'] ); ?></div>
                    <div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <# if ( settings.stats && settings.stats.length ) { #>
        <div class="stats">
            <# _.each( settings.stats, function( stat ) { #>
                <div class="stat-item">
                    <div class="stat-num">{{{ stat.number }}}</div>
                    <div class="stat-label">{{{ stat.label }}}</div>
                </div>
            <# } ); #>
        </div>
        <# } #>
        <?php
    }
}
