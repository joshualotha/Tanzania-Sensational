<?php
/**
 * Editable Tanzania Sensational header for Elementor Theme Builder.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TS_Header_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_header';
    }

    public function get_title() {
        return __( 'TS Header', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-header';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'brand_contact', [
            'label' => __( 'Brand & Contact', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'logo', [
            'label'   => __( 'Logo', 'tanzania-sensational' ),
            'type'    => Controls_Manager::MEDIA,
            'default' => [ 'url' => plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/logo.png' ],
        ] );
        $this->add_control( 'home_url', [
            'label'   => __( 'Logo Link', 'tanzania-sensational' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/' ],
        ] );
        $this->add_control( 'phone', [
            'label'   => __( 'Phone', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => '+255-621220912',
        ] );
        $this->add_control( 'email', [
            'label'   => __( 'Email', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => 'info@tanzaniasensational.co.tz',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'actions', [
            'label' => __( 'Calls to Action', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'top_cta_label', [
            'label'   => __( 'Top Bar Label', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Book Now', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'top_cta_url', [
            'label'   => __( 'Top Bar Link', 'tanzania-sensational' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact' ],
        ] );
        $this->add_control( 'main_cta_label', [
            'label'   => __( 'Navigation CTA Label', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Plan Your Journey', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'main_cta_url', [
            'label'   => __( 'Navigation CTA Link', 'tanzania-sensational' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'mega_navigation', [
            'label' => __( 'Mega Menus', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'safari_label', [
            'label' => __( 'Safari Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Safaris',
        ] );
        $this->add_control( 'safari_url', [
            'label' => __( 'Safari Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/safaris' ],
        ] );
        $this->add_control( 'safari_menu', [
            'label'       => __( 'Safari Mega Menu', 'tanzania-sensational' ),
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 14,
            'description' => __( 'Use Heading::Label|URL,Label|URL — one column per line.', 'tanzania-sensational' ),
            'default'     => "Destinations::Serengeti National Park|/safaris/destinations/serengeti,Ngorongoro Crater|/safaris/destinations/ngorongoro,Tarangire National Park|/safaris/destinations/tarangire\nPackages::Safari Overview|/safaris,Featured Packages|/safaris/packages,Group Joining|/safaris/group-joining\nSafari Guide::Safari Guide Overview|/safari-guide,What to Wear|/safari-guide/what-to-wear,Packing List|/safari-guide/packing-guide,Health & Safety|/safari-guide/health-and-safety,Safari Etiquette|/safari-guide/local-custom",
        ] );
        $this->add_control( 'trekking_label', [
            'label' => __( 'Trekking Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Trekking',
        ] );
        $this->add_control( 'trekking_url', [
            'label' => __( 'Trekking Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/#routes' ],
        ] );
        $this->add_control( 'trekking_menu', [
            'label'       => __( 'Trekking Mega Menu', 'tanzania-sensational' ),
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 18,
            'description' => __( 'Use Heading::Label|URL,Label|URL — one column per line.', 'tanzania-sensational' ),
            'default'     => "Destinations::Lemosho Route|/trekking/kilimanjaro/lemosho,Machame Route|/trekking/kilimanjaro/machame,Marangu Route|/trekking/kilimanjaro/marangu,Rongai Route|/trekking/kilimanjaro/rongai,Northern Circuit|/trekking/kilimanjaro/northern-circuit,Umbwe Route|/trekking/kilimanjaro/umbwe,Mount Meru Trek (4 Days)|/trekking/meru/mt-meru-4-days\nPreparation::Best Time to Climb|/trekking/prep/best-time,Best Routes|/trekking/prep/best-routes,Why Choose us|/trekking/prep/why-us,Tipping Guide|/trekking/prep/tipping-guide,Park Fees|/trekking/prep/park-fees,Toilets on Kili|/trekking/prep/toilets\nHealth & Safety::Vaccinations|/trekking/health/vaccinations,Altitude Sickness|/trekking/health/altitude-sickness,Diamox|/trekking/health/diamox,Oxygen & Safety|/trekking/health/oxygen\nDuring the Trek::Daily Routine|/trekking/during/daily-routine,Food & Drinks|/trekking/during/food-and-drinks,Daypack Essentials|/trekking/during/pack-your-daypack,Connectivity|/trekking/during/connectivity\nBefore You Go::Training Guide|/trekking/after/training,Gear List|/trekking/after/gear-list,Getting There|/trekking/after/getting-there,Visa Info|/trekking/after/visa",
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'simple_navigation', [
            'label' => __( 'Navigation Links', 'tanzania-sensational' ),
        ] );
        $repeater = new Repeater();
        $repeater->add_control( 'label', [ 'label' => __( 'Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'url', [ 'label' => __( 'Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL ] );
        $this->add_control( 'links', [
            'label'       => __( 'Links', 'tanzania-sensational' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ label }}}',
            'default'     => [
                [ 'label' => 'Zanzibar', 'url' => [ 'url' => '/zanzibar' ] ],
                [ 'label' => 'Departures', 'url' => [ 'url' => '/group-departures' ] ],
                [ 'label' => 'About Us', 'url' => [ 'url' => '/about-us' ] ],
                [ 'label' => 'Contact', 'url' => [ 'url' => '/contact' ] ],
            ],
        ] );
        $this->end_controls_section();
    }

    private function url( $control, $fallback = '#' ) {
        return ! empty( $control['url'] ) ? $control['url'] : $fallback;
    }

    private function render_mega_menu( $value ) {
        $columns = preg_split( '/\R/', trim( (string) $value ) );
        $column_count = count( array_filter( $columns, fn( $column ) => str_contains( $column, '::' ) ) );
        echo '<div class="mega-menu mega-menu--' . esc_attr( $column_count ) . '"><div class="mega-menu-inner">';
        foreach ( $columns as $column ) {
            if ( ! str_contains( $column, '::' ) ) {
                continue;
            }
            [ $heading, $items ] = array_map( 'trim', explode( '::', $column, 2 ) );
            echo '<div class="mega-col"><h3 class="mega-heading">' . esc_html( $heading ) . '</h3><ul class="mega-sub-links">';
            foreach ( explode( ',', $items ) as $item ) {
                if ( ! str_contains( $item, '|' ) ) {
                    continue;
                }
                [ $label, $url ] = array_map( 'trim', explode( '|', $item, 2 ) );
                echo '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
            }
            echo '</ul></div>';
        }
        echo '</div></div>';
    }

    private function render_mobile_columns( $value ) {
        echo '<div class="mobile-drawer-sub">';
        foreach ( preg_split( '/\R/', trim( (string) $value ) ) as $column ) {
            if ( ! str_contains( $column, '::' ) ) { continue; }
            [ $heading, $items ] = array_map( 'trim', explode( '::', $column, 2 ) );
            echo '<div class="mobile-drawer-sub-group"><span class="mobile-drawer-label">' . esc_html( $heading ) . '</span>';
            foreach ( explode( ',', $items ) as $item ) {
                if ( ! str_contains( $item, '|' ) ) { continue; }
                [ $label, $url ] = array_map( 'trim', explode( '|', $item, 2 ) );
                echo '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
            }
            echo '</div>';
        }
        echo '</div>';
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $phone_digits = preg_replace( '/\D/', '', $s['phone'] );
        ?>
        <div class="topbar">
            <div class="topbar-left">
                <div class="gtranslate_wrapper"></div>
                <a href="tel:<?php echo esc_attr( $phone_digits ); ?>" class="topbar-item phone-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg><?php echo esc_html( $s['phone'] ); ?></a>
                <span class="topbar-divider">|</span>
                <a href="mailto:<?php echo esc_attr( $s['email'] ); ?>" class="topbar-item email-item"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg><?php echo esc_html( $s['email'] ); ?></a>
            </div>
            <div class="topbar-right"><a href="<?php echo esc_url( $this->url( $s['top_cta_url'] ) ); ?>" class="topbar-cta"><?php echo esc_html( $s['top_cta_label'] ); ?></a></div>
        </div>
        <nav id="navbar">
            <div class="nav-island-inner">
                <a href="<?php echo esc_url( $this->url( $s['home_url'], '/' ) ); ?>" class="nav-logo"><img src="<?php echo esc_url( $s['logo']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" /></a>
                <ul class="nav-links">
                    <li class="dropdown mega-dropdown"><a href="<?php echo esc_url( $this->url( $s['safari_url'] ) ); ?>" class="dropdown-toggle"><?php echo esc_html( $s['safari_label'] ); ?><svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5"/></svg></a><?php $this->render_mega_menu( $s['safari_menu'] ); ?></li>
                    <li class="dropdown mega-dropdown"><a href="<?php echo esc_url( $this->url( $s['trekking_url'] ) ); ?>" class="dropdown-toggle"><?php echo esc_html( $s['trekking_label'] ); ?><svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5"/></svg></a><?php $this->render_mega_menu( $s['trekking_menu'] ); ?></li>
                    <?php foreach ( $s['links'] as $link ) : ?><li><a href="<?php echo esc_url( $this->url( $link['url'] ) ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li><?php endforeach; ?>
                </ul>
                <a href="<?php echo esc_url( $this->url( $s['main_cta_url'] ) ); ?>" class="nav-cta"><?php echo esc_html( $s['main_cta_label'] ); ?></a>
                <button class="mobile-hamburger" type="button" aria-label="<?php esc_attr_e( 'Toggle navigation', 'tanzania-sensational' ); ?>"><span></span><span></span><span></span></button>
            </div>
        </nav>
        <div class="mobile-drawer" id="ts-mobile-drawer" aria-hidden="true">
            <div class="mobile-drawer-backdrop"></div>
            <div class="mobile-drawer-panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site navigation', 'tanzania-sensational' ); ?>">
                <button class="mobile-drawer-close" type="button" aria-label="<?php esc_attr_e( 'Close menu', 'tanzania-sensational' ); ?>"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></button>
                <div class="mobile-drawer-scroll">
                    <div class="mobile-drawer-primary">
                        <div class="mobile-drawer-group">
                            <button class="mobile-drawer-link has-children" type="button" data-ts-drawer-toggle="safaris"><span><?php echo esc_html( $s['safari_label'] ); ?></span><svg class="mobile-drawer-chevron" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <div class="mobile-drawer-content" data-ts-drawer-content="safaris"><?php $this->render_mobile_columns( $s['safari_menu'] ); ?></div>
                        </div>
                        <div class="mobile-drawer-group">
                            <button class="mobile-drawer-link has-children" type="button" data-ts-drawer-toggle="trekking"><span><?php echo esc_html( $s['trekking_label'] ); ?></span><svg class="mobile-drawer-chevron" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3.5 5.25L7 8.75l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
                            <div class="mobile-drawer-content" data-ts-drawer-content="trekking"><?php $this->render_mobile_columns( $s['trekking_menu'] ); ?></div>
                        </div>
                        <?php foreach ( $s['links'] as $link ) : ?><a href="<?php echo esc_url( $this->url( $link['url'] ) ); ?>" class="mobile-drawer-link"><?php echo esc_html( $link['label'] ); ?></a><?php endforeach; ?>
                    </div>
                    <div class="mobile-drawer-footer">
                        <a href="<?php echo esc_url( $this->url( $s['main_cta_url'] ) ); ?>" class="mobile-drawer-cta"><?php echo esc_html( $s['main_cta_label'] ); ?><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        <a href="https://wa.me/<?php echo esc_attr( $phone_digits ); ?>" target="_blank" rel="noopener noreferrer" class="mobile-drawer-whatsapp">WhatsApp Us</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
