<?php
/** Editable homepage signature experiences section. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TS_Extensions_Widget extends Widget_Base {
    public function get_name() { return 'ts_extensions'; }
    public function get_title() { return __( 'TS Signature Experiences', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'heading_section', [ 'label' => __( 'Heading', 'tanzania-sensational' ) ] );
        $this->add_control( 'eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Signature Experiences' ] );
        $this->add_control( 'title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'default' => "Discover Our\nAfrican Odyssey", 'description' => __( 'The second line is italicized.', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'cards_section', [ 'label' => __( 'Experience Cards', 'tanzania-sensational' ) ] );
        $repeater = new Repeater();
        $repeater->add_control( 'image', [ 'label' => __( 'Background Image', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA ] );
        $repeater->add_control( 'title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'description', [ 'label' => __( 'Description', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4 ] );
        $repeater->add_control( 'link_text', [ 'label' => __( 'Link Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'link_url', [ 'label' => __( 'Link URL', 'tanzania-sensational' ), 'type' => Controls_Manager::URL ] );
        $this->add_control( 'cards', [
            'label'       => __( 'Experiences', 'tanzania-sensational' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => [
                [ 'image' => [ 'url' => 'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80' ], 'title' => 'Kilimanjaro Trekking', 'description' => 'Stand on the roof of Africa. Seven distinct routes, expert-certified guides, and a summit success rate that leads the industry.', 'link_text' => 'Explore Trekking', 'link_url' => [ 'url' => '/trekking/kilimanjaro' ] ],
                [ 'image' => [ 'url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80' ], 'title' => 'Zanzibar Escapes', 'description' => 'Trade the mountain air for the Indian Ocean breeze. Pristine white sands, turquoise waters, and ancient Stone Town history.', 'link_text' => 'Island Extensions', 'link_url' => [ 'url' => '/zanzibar' ] ],
            ],
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $lines    = array_map( 'trim', explode( "\n", (string) ( $settings['title'] ?? '' ) ) );
        ?>
        <section class="extensions" id="extensions">
            <?php if ( ! empty( $settings['eyebrow'] ) ) : ?><div class="section-eyebrow reveal"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text"><?php echo esc_html( $settings['eyebrow'] ); ?></span></div><?php endif; ?>
            <h2 class="section-title reveal"><?php echo esc_html( $lines[0] ?? '' ); ?><?php if ( ! empty( $lines[1] ) ) : ?><br><em><?php echo esc_html( $lines[1] ); ?></em><?php endif; ?></h2>
            <div class="extensions-grid">
                <?php foreach ( (array) ( $settings['cards'] ?? [] ) as $index => $card ) : ?>
                    <div class="extension-card reveal<?php echo $index ? ' reveal-delay-2' : ''; ?>">
                        <?php if ( ! empty( $card['image']['url'] ) ) : ?><div class="extension-img" style="background-image:url('<?php echo esc_url( $card['image']['url'] ); ?>')"></div><?php endif; ?>
                        <div class="extension-overlay"></div>
                        <div class="extension-content">
                            <h3 class="extension-name"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
                            <p class="extension-desc"><?php echo esc_html( $card['description'] ?? '' ); ?></p>
                            <?php if ( ! empty( $card['link_text'] ) ) : ?><a href="<?php echo esc_url( $card['link_url']['url'] ?? '#' ); ?>" class="extension-link"><?php echo esc_html( $card['link_text'] ); ?></a><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?><section class="extensions"><div class="section-eyebrow"><span class="section-eyebrow-text">{{{ settings.eyebrow }}}</span></div><h2 class="section-title">{{{ settings.title }}}</h2><div class="extensions-grid"><# _.each( settings.cards, function( card ) { #><div class="extension-card"><div class="extension-img" style="background-image:url('{{{ card.image.url }}}')"></div><div class="extension-overlay"></div><div class="extension-content"><h3 class="extension-name">{{{ card.title }}}</h3><p class="extension-desc">{{{ card.description }}}</p><span class="extension-link">{{{ card.link_text }}}</span></div></div><# }); #></div></section><?php
    }
}

