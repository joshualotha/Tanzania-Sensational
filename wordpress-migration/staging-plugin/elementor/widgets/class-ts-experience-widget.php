<?php
/**
 * Editable homepage experience section.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TS_Experience_Widget extends Widget_Base {
    public function get_name() {
        return 'ts_experience';
    }

    public function get_title() {
        return __( 'TS Experience', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-image-before-after';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tanzania-sensational' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'The Difference', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'title', [
            'label'       => __( 'Heading', 'tanzania-sensational' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => 'Wild. <em>Authentic.</em><br>Unforgettable.',
            'description' => __( 'The em and br tags are supported.', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'body', [
            'label'   => __( 'Description', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXTAREA,
            'rows'    => 5,
            'default' => __( "A true safari demands more than a vehicle and a checklist — it demands local knowledge, seasoned naturalists, and a team that's guided thousands of guests across the Serengeti, Ngorongoro, and beyond. That's us.", 'tanzania-sensational' ),
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'images', [
            'label' => __( 'Images and Badge', 'tanzania-sensational' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'main_image', [
            'label'   => __( 'Main Image', 'tanzania-sensational' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=85&auto=format&fit=crop' ],
        ] );

        $this->add_control( 'secondary_image', [
            'label'   => __( 'Secondary Image', 'tanzania-sensational' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=85&auto=format&fit=crop' ],
        ] );

        $this->add_control( 'badge_number', [
            'label'   => __( 'Badge Number', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '15+',
        ] );

        $this->add_control( 'badge_text', [
            'label'   => __( 'Badge Text', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => "Years guiding\nacross Africa",
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'pillars_section', [
            'label' => __( 'Value Pillars', 'tanzania-sensational' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new Repeater();
        $repeater->add_control( 'number', [
            'label' => __( 'Number', 'tanzania-sensational' ),
            'type'  => Controls_Manager::TEXT,
        ] );
        $repeater->add_control( 'title', [
            'label' => __( 'Title', 'tanzania-sensational' ),
            'type'  => Controls_Manager::TEXT,
        ] );
        $repeater->add_control( 'description', [
            'label' => __( 'Description', 'tanzania-sensational' ),
            'type'  => Controls_Manager::TEXTAREA,
            'rows'  => 3,
        ] );

        $this->add_control( 'pillars', [
            'label'       => __( 'Pillars', 'tanzania-sensational' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ number }}} — {{{ title }}}',
            'default'     => [
                [ 'number' => '01', 'title' => 'Expert Naturalist Guides', 'description' => 'Every guide is a certified naturalist with deep knowledge of East African ecosystems, wildlife behavior, and photography positioning.' ],
                [ 'number' => '02', 'title' => 'Handcrafted Itineraries', 'description' => 'We design each route around seasonal wildlife movements, optimal light for photography, and secluded camps far from the crowds.' ],
                [ 'number' => '03', 'title' => 'Transparent Pricing & Flexibility', 'description' => 'Solo traveler or a private party of 12, our pricing is clear and competitive. Join a group departure or charter a bespoke expedition.' ],
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $settings  = $this->get_settings_for_display();
        $main      = $settings['main_image']['url'] ?? '';
        $secondary = $settings['secondary_image']['url'] ?? '';
        ?>
        <section class="experience">
            <div class="experience-visual">
                <div class="exp-img-main"<?php if ( $main ) : ?> style="background-image:url('<?php echo esc_url( $main ); ?>')"<?php endif; ?>></div>
                <div class="exp-img-secondary"<?php if ( $secondary ) : ?> style="background-image:url('<?php echo esc_url( $secondary ); ?>')"<?php endif; ?>></div>
                <?php if ( ! empty( $settings['badge_number'] ) || ! empty( $settings['badge_text'] ) ) : ?>
                    <div class="exp-badge-float shadow-premium">
                        <div class="exp-badge-num"><?php echo esc_html( $settings['badge_number'] ); ?></div>
                        <div class="exp-badge-text"><?php echo nl2br( esc_html( $settings['badge_text'] ) ); ?></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="experience-content">
                <?php if ( ! empty( $settings['eyebrow'] ) ) : ?><div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text"><?php echo esc_html( $settings['eyebrow'] ); ?></span></div><?php endif; ?>
                <?php if ( ! empty( $settings['title'] ) ) : ?><h2 class="section-title"><?php echo wp_kses( $settings['title'], [ 'em' => [], 'br' => [] ] ); ?></h2><?php endif; ?>
                <?php if ( ! empty( $settings['body'] ) ) : ?><p class="experience-body"><?php echo esc_html( $settings['body'] ); ?></p><?php endif; ?>
                <?php if ( ! empty( $settings['pillars'] ) ) : ?>
                    <div class="pillars">
                        <?php foreach ( $settings['pillars'] as $pillar ) : ?>
                            <div class="pillar">
                                <span class="pillar-num"><?php echo esc_html( $pillar['number'] ?? '' ); ?></span>
                                <div><div class="pillar-title"><?php echo esc_html( $pillar['title'] ?? '' ); ?></div><p class="pillar-desc"><?php echo esc_html( $pillar['description'] ?? '' ); ?></p></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <section class="experience">
            <div class="experience-visual"><div class="exp-img-main" style="background-image:url('{{{ settings.main_image.url }}}')"></div><div class="exp-img-secondary" style="background-image:url('{{{ settings.secondary_image.url }}}')"></div><div class="exp-badge-float shadow-premium"><div class="exp-badge-num">{{{ settings.badge_number }}}</div><div class="exp-badge-text">{{{ settings.badge_text }}}</div></div></div>
            <div class="experience-content"><div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">{{{ settings.eyebrow }}}</span></div><h2 class="section-title">{{{ settings.title }}}</h2><p class="experience-body">{{{ settings.body }}}</p><div class="pillars"><# _.each( settings.pillars, function( pillar ) { #><div class="pillar"><span class="pillar-num">{{{ pillar.number }}}</span><div><div class="pillar-title">{{{ pillar.title }}}</div><p class="pillar-desc">{{{ pillar.description }}}</p></div></div><# }); #></div></div>
        </section>
        <?php
    }
}

