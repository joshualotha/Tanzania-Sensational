<?php
/**
 * Editable homepage testimonials section.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TS_Testimonials_Widget extends Widget_Base {
    public function get_name() { return 'ts_testimonials'; }
    public function get_title() { return __( 'TS Testimonials', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-testimonial'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'heading_section', [ 'label' => __( 'Heading', 'tanzania-sensational' ) ] );
        $this->add_control( 'eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'The Human Connection' ] );
        $this->add_control( 'title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'From the <em>Summit Diary</em>', 'description' => __( 'The em tag is supported.', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'testimonials_section', [ 'label' => __( 'Testimonials', 'tanzania-sensational' ) ] );
        $repeater = new Repeater();
        $repeater->add_control( 'quote', [ 'label' => __( 'Quote', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5 ] );
        $repeater->add_control( 'author', [ 'label' => __( 'Guest Name', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'origin', [ 'label' => __( 'Location', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'image', [ 'label' => __( 'Portrait', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA ] );
        $this->add_control( 'testimonials', [
            'label'       => __( 'Guest Stories', 'tanzania-sensational' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ author }}} — {{{ origin }}}',
            'default'     => [
                [ 'quote' => 'The guides were extraordinary, they knew exactly when to push and when to rest. Reaching Uhuru Peak at sunrise was the most profound moment of my life.', 'author' => 'James Hartwell', 'origin' => 'London, United Kingdom', 'image' => [ 'url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80&auto=format&fit=crop' ] ],
                [ 'quote' => "I joined a group departure as a solo traveler and couldn't have been more impressed. The safety protocols, the food, the team's energy, truly world-class.", 'author' => 'Sarah Chen', 'origin' => 'San Francisco, USA', 'image' => [ 'url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop' ] ],
                [ 'quote' => '8 Tage Lemosho Route, absolut unvergesslich. Professionell, sicher, und die persönliche Betreuung war unübertroffen. Nächstes Ziel: Mt. Meru.', 'author' => 'Klaus Müller', 'origin' => 'Munich, Germany', 'image' => [ 'url' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=800&auto=format&fit=crop' ] ],
            ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="testimonials-v3">
            <div class="testimonials-header-v3">
                <?php if ( ! empty( $settings['eyebrow'] ) ) : ?><div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text"><?php echo esc_html( $settings['eyebrow'] ); ?></span></div><?php endif; ?>
                <?php if ( ! empty( $settings['title'] ) ) : ?><h2 class="section-title-v3"><?php echo wp_kses( $settings['title'], [ 'em' => [] ] ); ?></h2><?php endif; ?>
            </div>
            <div class="testi-grid-v3">
                <?php foreach ( (array) ( $settings['testimonials'] ?? [] ) as $testimonial ) : ?>
                    <div class="testi-card-v3">
                        <div class="testi-quote-mark">“</div>
                        <p class="testi-text-v3"><?php echo esc_html( $testimonial['quote'] ?? '' ); ?></p>
                        <div class="testi-author-v3">
                            <?php if ( ! empty( $testimonial['image']['url'] ) ) : ?><div class="testi-avatar-v3" style="background-image:url('<?php echo esc_url( $testimonial['image']['url'] ); ?>')"></div><?php endif; ?>
                            <div class="testi-meta-v3"><div class="testi-name-v3"><?php echo esc_html( $testimonial['author'] ?? '' ); ?></div><div class="testi-origin-v3"><?php echo esc_html( $testimonial['origin'] ?? '' ); ?></div></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <section class="testimonials-v3"><div class="testimonials-header-v3"><div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">{{{ settings.eyebrow }}}</span></div><h2 class="section-title-v3">{{{ settings.title }}}</h2></div><div class="testi-grid-v3"><# _.each( settings.testimonials, function( item ) { #><div class="testi-card-v3"><div class="testi-quote-mark">“</div><p class="testi-text-v3">{{{ item.quote }}}</p><div class="testi-author-v3"><div class="testi-avatar-v3" style="background-image:url('{{{ item.image.url }}}')"></div><div class="testi-meta-v3"><div class="testi-name-v3">{{{ item.author }}}</div><div class="testi-origin-v3">{{{ item.origin }}}</div></div></div></div><# }); #></div></section>
        <?php
    }
}

