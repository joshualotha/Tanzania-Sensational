<?php
/** Editable single-post reading layout for standard blog posts. */
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Single_Blog_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'ts_single_blog';
    }

    public function get_title()
    {
        return __('TS Single Blog Article', 'tanzania-sensational');
    }

    public function get_icon()
    {
        return 'eicon-single-post';
    }

    public function get_categories()
    {
        return ['ts-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('blog_article_content', [
            'label' => __('Article Layout', 'tanzania-sensational'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('back_label', [
            'label' => __('Back Link Text', 'tanzania-sensational'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Trekker’s Journal', 'tanzania-sensational'),
        ]);
        $this->add_control('back_url', [
            'label' => __('Back Link URL', 'tanzania-sensational'),
            'type' => Controls_Manager::URL,
            'default' => ['url' => '/blog'],
        ]);
        $this->add_control('share_heading', [
            'label' => __('Share Heading', 'tanzania-sensational'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Share Story', 'tanzania-sensational'),
        ]);
        $this->add_control('related_heading', [
            'label' => __('Related Stories Heading', 'tanzania-sensational'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Related Stories', 'tanzania-sensational'),
        ]);
        $this->add_control('show_share', [
            'label' => __('Show Share Links', 'tanzania-sensational'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);
        $this->add_control('show_related', [
            'label' => __('Show Related Stories', 'tanzania-sensational'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $post_id = (int) get_the_ID();
        $post = get_post($post_id);
        if (!$post || 'post' !== $post->post_type) {
            if (current_user_can('edit_posts')) {
                echo '<p class="blog-empty-state" role="status">' . esc_html__('Preview this widget on a standard blog post.', 'tanzania-sensational') . '</p>';
            }
            return;
        }

        $title = get_the_title($post);
        $image_url = (string) ts_blog_get_field('ts_blog_hero_image_url', $post_id, '');
        $image_alt = (string) ts_blog_get_field('ts_blog_hero_image_alt', $post_id, $title);
        $author = (string) ts_blog_get_field('ts_blog_author_display', $post_id, 'Tanzania Sensational');
        $category = ts_blog_primary_category($post_id);
        $published_date = get_the_date('Y-m-d', $post);
        $permalink = get_permalink($post);
        $settings_back_url = (string) ($settings['back_url']['url'] ?? '/blog');
        $back_url = '' !== $settings_back_url ? $settings_back_url : home_url('/blog');
        $share_url = rawurlencode($permalink);
        $share_title = rawurlencode($title);
        $body = apply_filters('the_content', (string) get_post_field('post_content', $post_id));
        ?>
        <article class="blog-root blog-root--single">
            <section class="blog-article-hero" aria-labelledby="ts-blog-article-title">
                <?php if ('' !== $image_url) : ?>
                    <div class="blog-article-bg">
                        <?php echo ts_blog_image_markup($image_url, $image_alt, 'blog-article-image', 'eager', true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                <?php endif; ?>
                <div class="blog-article-overlay" aria-hidden="true"></div>
                <div class="blog-back-wrapper">
                    <a class="blog-back-mag" href="<?php echo esc_url($back_url); ?>">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5M12 19l-7-7 7-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        <span><?php echo esc_html($settings['back_label'] ?? __('Trekker’s Journal', 'tanzania-sensational')); ?></span>
                    </a>
                </div>
                <header class="blog-article-header">
                    <h1 class="blog-article-title" id="ts-blog-article-title"><?php echo esc_html($title); ?></h1>
                    <div class="blog-article-meta">
                        <span><?php echo esc_html__('By ', 'tanzania-sensational') . esc_html($author); ?></span>
                        <?php if ('' !== $category) : ?><span class="gold"><?php echo esc_html($category); ?></span><?php endif; ?>
                        <time datetime="<?php echo esc_attr($published_date); ?>"><?php echo esc_html(get_the_date('M j, Y', $post)); ?></time>
                    </div>
                </header>
            </section>

            <div class="blog-article-layout">
                <div class="blog-article-body">
                    <?php echo $body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- standard WordPress the_content filters sanitize and format post content. ?>
                </div>

                <?php if ('yes' === ($settings['show_share'] ?? 'yes') || 'yes' === ($settings['show_related'] ?? 'yes')) : ?>
                    <aside class="blog-side-pane" aria-label="<?php echo esc_attr__('Article sharing and related stories', 'tanzania-sensational'); ?>">
                        <?php if ('yes' === ($settings['show_share'] ?? 'yes')) : ?>
                            <section class="blog-side-share" aria-labelledby="ts-blog-share-heading">
                                <h2 class="blog-side-heading" id="ts-blog-share-heading"><?php echo esc_html($settings['share_heading'] ?? __('Share Story', 'tanzania-sensational')); ?></h2>
                                <div class="blog-share-links">
                                    <a class="blog-share-btn" href="<?php echo esc_url('https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__('Share on LinkedIn', 'tanzania-sensational'); ?>">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5.2 3.7a2.1 2.1 0 1 1 0 4.2 2.1 2.1 0 0 1 0-4.2ZM3.5 9.4h3.4v11.1H3.5V9.4Zm5.6 0h3.2v1.5h.1c.5-.9 1.7-1.9 3.5-1.9 3.7 0 4.4 2.4 4.4 5.5v6h-3.4v-5.3c0-1.3 0-3-1.9-3s-2.2 1.4-2.2 2.9v5.4H9.1V9.4Z" /></svg>
                                    </a>
                                    <a class="blog-share-btn" href="<?php echo esc_url('https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__('Share on X', 'tanzania-sensational'); ?>">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3L12 14.6 5.5 22H2.4l7.3-8.4L1.9 2h6.5l4.5 6.7L18.9 2Zm-1.1 18h1.7L7.3 3.9H5.5L17.8 20Z" /></svg>
                                    </a>
                                    <a class="blog-share-btn" href="<?php echo esc_url('https://www.facebook.com/sharer/sharer.php?u=' . $share_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__('Share on Facebook', 'tanzania-sensational'); ?>">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.4 21v-8.2h2.8l.4-3.2h-3.2V7.5c0-.9.3-1.6 1.6-1.6h1.7V3.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.4v2.2H7.2v3.2H10V21h3.4Z" /></svg>
                                    </a>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php if ('yes' === ($settings['show_related'] ?? 'yes')) : ?>
                            <section class="blog-side-related" aria-labelledby="ts-blog-related-heading">
                                <h2 class="blog-side-heading" id="ts-blog-related-heading"><?php echo esc_html($settings['related_heading'] ?? __('Related Stories', 'tanzania-sensational')); ?></h2>
                                <?php
                                $related_query = new WP_Query([
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 2,
                                    'post__not_in' => array_values(array_unique(array_merge([$post_id], ts_blog_legacy_sample_post_ids()))),
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'ignore_sticky_posts' => true,
                                    'no_found_rows' => true,
                                ]);
                                $related_posts = is_array($related_query->posts ?? null) ? $related_query->posts : [];
                                ?>
                                <?php foreach ($related_posts as $related) : ?>
                                    <?php
                                    $related_id = (int) $related->ID;
                                    $related_image = (string) ts_blog_get_field('ts_blog_hero_image_url', $related_id, '');
                                    $related_alt = (string) ts_blog_get_field('ts_blog_hero_image_alt', $related_id, get_the_title($related));
                                    $related_category = ts_blog_primary_category($related_id);
                                    ?>
                                    <a class="blog-related-card" href="<?php echo esc_url(get_permalink($related)); ?>">
                                        <span class="blog-related-img<?php echo '' === $related_image ? ' blog-related-img--empty' : ''; ?>">
                                            <?php if ('' !== $related_image) : ?>
                                                <?php echo ts_blog_image_markup($related_image, $related_alt, 'blog-related-image', 'lazy'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                            <?php endif; ?>
                                        </span>
                                        <span class="blog-related-info">
                                            <?php if ('' !== $related_category) : ?><span class="blog-related-cat"><?php echo esc_html($related_category); ?></span><?php endif; ?>
                                            <span class="blog-related-title"><?php echo esc_html(get_the_title($related)); ?></span>
                                        </span>
                                    </a>
                                <?php endforeach; ?>
                                <?php if (!$related_posts) : ?><p role="status"><?php echo esc_html__('More stories will appear here soon.', 'tanzania-sensational'); ?></p><?php endif; ?>
                            </section>
                        <?php endif; ?>
                    </aside>
                <?php endif; ?>
            </div>
        </article>
        <?php
    }
}
