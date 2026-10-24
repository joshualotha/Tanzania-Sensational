<?php
/**
 * TS Footer Widget for Elementor.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

class TS_Footer_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_footer';
    }

    public function get_title() {
        return __( 'TS Footer', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-footer';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'brand_section',
            [
                'label' => __( 'Brand Column', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'logo',
            [
                'label'   => __( 'Logo', 'tanzania-sensational' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugin_dir_url( dirname( dirname( __FILE__ ) ) ) . 'assets/logo.png',
                ],
            ]
        );

        $this->add_control(
            'tagline',
            [
                'label'   => __( 'Tagline', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "East Africa's premier safari outfitter. Guiding adventurers across the Serengeti, Ngorongoro, and Kilimanjaro since 2009.", 'tanzania-sensational' ),
                'rows'    => 3,
            ]
        );

        $this->add_control(
            'email',
            [
                'label'   => __( 'Email', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'info@tanzaniasensational.co.tz',
            ]
        );

        $this->add_control(
            'phone',
            [
                'label'   => __( 'Phone', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => '+255-621220912',
            ]
        );

        $this->add_control(
            'address',
            [
                'label'   => __( 'Address', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Moshi, Kilimanjaro Region', 'tanzania-sensational' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'newsletter_section',
            [
                'label' => __( 'Newsletter Strip', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'newsletter_eyebrow',
            [
                'label'   => __( 'Eyebrow', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Stay Connected', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'newsletter_title',
            [
                'label'   => __( 'Title', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Stories from the wild', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'newsletter_subtitle',
            [
                'label'   => __( 'Subtitle', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'Safari dispatches, wildlife stories & exclusive departure alerts, delivered to your inbox.', 'tanzania-sensational' ),
                'rows'    => 2,
            ]
        );

        $this->add_control(
            'newsletter_form_action',
            [
                'label'   => __( 'Form Action URL', 'tanzania-sensational' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '/contact',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'columns_section',
            [
                'label' => __( 'Footer Columns', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'column_title',
            [
                'label'   => __( 'Column Title', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Column Title', 'tanzania-sensational' ),
            ]
        );

        $repeater->add_control(
            'links',
            [
                'label'       => __( 'Links (one per line: Label|URL)', 'tanzania-sensational' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => "All Safaris|/safaris\nSafari Guide|/safaris/guide",
                'rows'        => 6,
                'description' => __( 'Enter each link on a new line as Label|URL', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label'       => __( 'Columns', 'tanzania-sensational' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'column_title' => __( 'Safaris & Destinations', 'tanzania-sensational' ),
                        'links'        => "All Safaris|/safaris\nSafari Guide|/safaris/guide\nFeatured Packages|/safaris/packages\nSerengeti|/safaris/destinations/serengeti\nNgorongoro Crater|/safaris/destinations/ngorongoro-crater\nTarangire|/safaris/destinations/tarangire\nZanzibar|/zanzibar",
                    ],
                    [
                        'column_title' => __( 'Kilimanjaro', 'tanzania-sensational' ),
                        'links'        => "Overview & Routes|/trekking/kilimanjaro\nLemosho Route|/trekking/kilimanjaro/lemosho\nMachame Route|/trekking/kilimanjaro/machame\nNorthern Circuit|/trekking/kilimanjaro/northern-circuit\nMarangu Route|/trekking/kilimanjaro/marangu\nRongai Route|/trekking/kilimanjaro/rongai\nUmbwe Route|/trekking/kilimanjaro/umbwe",
                    ],
                    [
                        'column_title' => __( 'Company', 'tanzania-sensational' ),
                        'links'        => "About Us|/about-us\nOur Guides|/company/our-guides\nSafety Protocols|/company/safety-protocols\nAdventurer's Blog|/blog\nContact|/contact\nGroup Departures|/group-departures\nFAQ|/faq",
                    ],
                ],
                'title_field' => '{{{ column_title }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'social_section',
            [
                'label' => __( 'Social & Copyright', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $social_repeater = new Repeater();

        $social_repeater->add_control(
            'network',
            [
                'label'   => __( 'Network', 'tanzania-sensational' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'instagram',
                'options' => [
                    'instagram' => __( 'Instagram', 'tanzania-sensational' ),
                    'facebook'  => __( 'Facebook', 'tanzania-sensational' ),
                    'linkedin'  => __( 'LinkedIn', 'tanzania-sensational' ),
                    'twitter'   => __( 'Twitter / X', 'tanzania-sensational' ),
                    'youtube'   => __( 'YouTube', 'tanzania-sensational' ),
                ],
            ]
        );

        $social_repeater->add_control(
            'url',
            [
                'label'   => __( 'URL', 'tanzania-sensational' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'social_links',
            [
                'label'   => __( 'Social Links', 'tanzania-sensational' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $social_repeater->get_controls(),
                'default' => [],
            ]
        );

        $this->add_control(
            'copyright',
            [
                'label'   => __( 'Copyright', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( '&copy; 2026 Tanzania Sensational', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'crafted',
            [
                'label'   => __( 'Crafted Text', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Crafted with purpose in Tanzania', 'tanzania-sensational' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $logo_url = ! empty( $settings['logo']['url'] ) ? $settings['logo']['url'] : '';
        $phone_digits = preg_replace( '/\D/', '', $settings['phone'] );
        $form_action = ! empty( $settings['newsletter_form_action']['url'] ) ? $settings['newsletter_form_action']['url'] : '/contact';
        ?>
        <div class="footer-organic">
            <div class="footer-grain"></div>
            <div class="footer-watermark" aria-hidden="true">Karibu</div>
            <svg class="footer-topo" viewBox="0 0 1440 600" preserveAspectRatio="none" aria-hidden="true">
                <path d="M-20,200 Q200,120 400,200 T800,180 T1200,220 T1460,180" fill="none" stroke="rgba(140,109,82,0.06)" stroke-width="1.5" />
                <path d="M-20,260 Q240,180 480,260 T880,240 T1240,280 T1460,240" fill="none" stroke="rgba(140,109,82,0.05)" stroke-width="1.2" />
                <path d="M-20,320 Q180,260 420,320 T840,300 T1280,340 T1460,310" fill="none" stroke="rgba(140,109,82,0.04)" stroke-width="1" />
                <path d="M-20,400 Q260,340 500,400 T900,380 T1300,420 T1460,390" fill="none" stroke="rgba(140,109,82,0.035)" stroke-width="0.8" />
                <path d="M-20,480 Q220,420 460,480 T860,460 T1260,500 T1460,470" fill="none" stroke="rgba(140,109,82,0.03)" stroke-width="0.6" />
            </svg>

            <div class="footer-wave-divider">
                <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,48 C180,80 360,16 540,48 C720,80 900,16 1080,48 C1260,80 1350,32 1440,48 L1440,80 L0,80 Z" fill="var(--footer-bg)" />
                </svg>
            </div>

            <div class="footer-inner">
                <div class="footer-cta-strip">
                    <div class="footer-cta-content">
                        <span class="footer-cta-eyebrow"><?php echo esc_html( $settings['newsletter_eyebrow'] ); ?></span>
                        <h3 class="footer-cta-title"><?php echo esc_html( $settings['newsletter_title'] ); ?></h3>
                        <p class="footer-cta-sub"><?php echo esc_html( $settings['newsletter_subtitle'] ); ?></p>
                    </div>
                    <form class="footer-cta-form" action="<?php echo esc_url( $form_action ); ?>" method="get">
                        <div class="footer-input-wrap">
                            <input type="email" name="email" placeholder="your@email.com" class="footer-email-input" required />
                            <button type="submit" class="footer-submit-btn" aria-label="<?php esc_attr_e( 'Subscribe', 'tanzania-sensational' ); ?>">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="footer-upper">
                    <div class="footer-brand-col">
                        <?php if ( $logo_url ) : ?>
                        <div class="footer-logo-wrap">
                            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'Tanzania Sensational', 'tanzania-sensational' ); ?>" loading="lazy" />
                        </div>
                        <?php endif; ?>
                        <p class="footer-tagline"><?php echo esc_html( $settings['tagline'] ); ?></p>

                        <div class="footer-contact-stack">
                            <?php if ( $settings['email'] ) : ?>
                            <a href="mailto:<?php echo esc_attr( $settings['email'] ); ?>" class="footer-contact-link">
                                <span class="footer-contact-icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4.5l6 4.5 6-4.5M2 3.5h12a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5H2A1.5 1.5 0 01.5 12V5A1.5 1.5 0 012 3.5z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" /></svg>
                                </span>
                                <?php echo esc_html( $settings['email'] ); ?>
                            </a>
                            <?php endif; ?>
                            <?php if ( $settings['phone'] ) : ?>
                            <a href="tel:<?php echo esc_attr( $phone_digits ); ?>" class="footer-contact-link">
                                <span class="footer-contact-icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.5 2.5c0-.3.2-.5.5-.5h2.6c.2 0 .4.2.5.4l1 2.5c.1.2 0 .4-.1.6L6 7c.8 1.5 2.4 3.1 4 4l1-1c.2-.1.4-.2.6-.1l2.5 1c.2.1.4.3.4.5v2.6c0 .3-.2.5-.5.5C5.5 14 1 9.5 1 4c0-.3 0-.5.5-.5z" stroke="currentColor" stroke-width="1.2" /></svg>
                                </span>
                                <?php echo esc_html( $settings['phone'] ); ?>
                            </a>
                            <?php endif; ?>
                        </div>

                        <?php if ( $settings['address'] ) : ?>
                        <div class="footer-location-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span><?php echo esc_html( $settings['address'] ); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="footer-nav-columns">
                        <?php foreach ( $settings['columns'] as $column ) : ?>
                            <?php
                            $links = [];
                            if ( ! empty( $column['links'] ) ) {
                                $lines = preg_split( '/\r\n|\r|\n/', $column['links'] );
                                foreach ( $lines as $line ) {
                                    $parts = array_map( 'trim', explode( '|', $line, 2 ) );
                                    if ( count( $parts ) === 2 && $parts[0] && $parts[1] ) {
                                        $links[] = [ 'label' => $parts[0], 'url' => $parts[1] ];
                                    }
                                }
                            }
                            ?>
                            <div class="footer-nav-col">
                                <div class="footer-nav-label"><span class="footer-label-line"></span><?php echo esc_html( $column['column_title'] ); ?></div>
                                <?php if ( ! empty( $links ) ) : ?>
                                <ul class="footer-links">
                                    <?php foreach ( $links as $link ) : ?>
                                        <li><a href="<?php echo esc_url( $link['url'] ); ?>"><?php echo esc_html( $link['label'] ); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <?php if ( ! empty( $settings['social_links'] ) ) : ?>
                        <div class="footer-nav-col">
                            <div class="footer-nav-label"><span class="footer-label-line"></span><?php esc_html_e( 'Follow Along', 'tanzania-sensational' ); ?></div>
                            <div class="footer-socials">
                                <?php foreach ( $settings['social_links'] as $social ) :
                                    if ( empty( $social['url']['url'] ) ) continue;
                                    $network = $social['network'];
                                    $url = $social['url']['url'];
                                    $target = ! empty( $social['url']['is_external'] ) ? ' target="_blank"' : '';
                                    $nofollow = ! empty( $social['url']['nofollow'] ) ? ' rel="nofollow noreferrer"' : ' rel="noreferrer"';
                                ?>
                                    <a href="<?php echo esc_url( $url ); ?>" class="social-link" aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>"<?php echo $target . $nofollow; ?>>
                                        <?php echo $this->get_social_icon( $network ); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="footer-lower">
                    <div class="footer-lower-left">
                        <span class="footer-copy"><?php echo wp_kses_post( $settings['copyright'] ); ?></span>
                        <span class="footer-dot">·</span>
                        <span class="footer-copy"><?php esc_html_e( 'All rights reserved', 'tanzania-sensational' ); ?></span>
                    </div>
                    <div class="footer-lower-right">
                        <span class="footer-craft"><?php echo esc_html( $settings['crafted'] ); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    protected function get_social_icon( $network ) {
        $icons = [
            'instagram' => '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>',
            'facebook'  => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>',
            'linkedin'  => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>',
            'twitter'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
            'youtube'   => '<svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.81zM9.55 15.5V8.5l6.27 3.5-6.27 3.5z"/></svg>',
        ];
        return $icons[ $network ] ?? '';
    }

    protected function content_template() {
        ?>
        <div class="footer-organic">
            <div class="footer-grain"></div>
            <div class="footer-watermark" aria-hidden="true">Karibu</div>
            <div class="footer-inner">
                <div class="footer-cta-strip">
                    <div class="footer-cta-content">
                        <span class="footer-cta-eyebrow">{{{ settings.newsletter_eyebrow }}}</span>
                        <h3 class="footer-cta-title">{{{ settings.newsletter_title }}}</h3>
                        <p class="footer-cta-sub">{{{ settings.newsletter_subtitle }}}</p>
                    </div>
                </div>
                <div class="footer-upper">
                    <div class="footer-brand-col">
                        <# if ( settings.logo.url ) { #>
                        <div class="footer-logo-wrap">
                            <img src="{{{ settings.logo.url }}}" alt="" loading="lazy" />
                        </div>
                        <# } #>
                        <p class="footer-tagline">{{{ settings.tagline }}}</p>
                    </div>
                </div>
                <div class="footer-lower">
                    <span class="footer-copy">{{{ settings.copyright }}}</span>
                    <span class="footer-craft">{{{ settings.crafted }}}</span>
                </div>
            </div>
        </div>
        <?php
    }
}
