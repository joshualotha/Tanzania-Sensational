<?php
/** Editable final homepage call to action. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_CTA_Widget extends Widget_Base {
    public function get_name() { return 'ts_cta'; }
    public function get_title() { return __( 'TS Journey CTA', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [ 'label' => __( 'Content', 'tanzania-sensational' ) ] );
        $this->add_control( 'background_image', [ 'label' => __( 'Background Image', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=2000&auto=format&fit=crop' ] ] );
        $this->add_control( 'title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'default' => 'The Summit<br>is <em>Waiting For You</em>', 'description' => __( 'The em and br tags are supported.', 'tanzania-sensational' ) ] );
        $this->add_control( 'primary_text', [ 'label' => __( 'Primary Button Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Plan My Journey' ] );
        $this->add_control( 'primary_url', [ 'label' => __( 'Primary Button URL', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->add_control( 'secondary_text', [ 'label' => __( 'Secondary Button Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'WhatsApp Us' ] );
        $this->add_control( 'secondary_url', [ 'label' => __( 'Secondary Button URL', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => 'https://wa.me/255743262822', 'is_external' => true ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <section class="cta-banner-v3">
            <?php if ( ! empty( $settings['background_image']['url'] ) ) : ?><div class="cta-bg-v3" style="background-image:url('<?php echo esc_url( $settings['background_image']['url'] ); ?>')"></div><?php endif; ?>
            <div class="cta-overlay-v3"></div>
            <div class="cta-content-v3">
                <h2 class="cta-title-v3"><?php echo wp_kses( $settings['title'] ?? '', [ 'em' => [], 'br' => [] ] ); ?></h2>
                <div class="cta-btns-v3">
                    <?php if ( ! empty( $settings['primary_text'] ) ) : ?><a href="<?php echo esc_url( $settings['primary_url']['url'] ?? '#' ); ?>" class="nav-cta" style="position:relative;"><?php echo esc_html( $settings['primary_text'] ); ?></a><?php endif; ?>
                    <?php if ( ! empty( $settings['secondary_text'] ) ) : ?><a href="<?php echo esc_url( $settings['secondary_url']['url'] ?? '#' ); ?>"<?php echo ! empty( $settings['secondary_url']['is_external'] ) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?> class="btn-secondary-light"><?php echo esc_html( $settings['secondary_text'] ); ?></a><?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?><section class="cta-banner-v3"><div class="cta-bg-v3" style="background-image:url('{{{ settings.background_image.url }}}')"></div><div class="cta-overlay-v3"></div><div class="cta-content-v3"><h2 class="cta-title-v3">{{{ settings.title }}}</h2><div class="cta-btns-v3"><span class="nav-cta">{{{ settings.primary_text }}}</span><span class="btn-secondary-light">{{{ settings.secondary_text }}}</span></div></div></section><?php
    }
}

