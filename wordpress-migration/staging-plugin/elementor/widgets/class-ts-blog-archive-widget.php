<?php
/** Editable blog archive widget. */
if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Blog_Archive_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'ts_blog_archive';
    }

    public function get_title()
    {
        return __('TS Blog Archive', 'tanzania-sensational');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['ts-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('blog_archive_content', [
            'label' => __('Archive Content', 'tanzania-sensational'),
            'tab' => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('featured_cta', [
            'label' => __('Featured Link Text', 'tanzania-sensational'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Read Featured Story', 'tanzania-sensational'),
        ]);
        $this->add_control('card_cta', [
            'label' => __('Article Link Text', 'tanzania-sensational'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Continue Reading', 'tanzania-sensational'),
        ]);
        $this->add_control('posts_per_page', [
            'label' => __('Articles to Show', 'tanzania-sensational'),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 24,
            'default' => 12,
        ]);
        $this->add_control('show_excerpts', [
            'label' => __('Show Article Excerpts', 'tanzania-sensational'),
            'type' => Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => 'yes',
        ]);

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $posts_per_page = max(1, min(24, (int) ($settings['posts_per_page'] ?? 12)));
        $legacy_sample_ids = ts_blog_legacy_sample_post_ids();
        $featured_query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'post__not_in' => $legacy_sample_ids,
            'meta_key' => 'ts_blog_featured',
            'meta_value' => '1',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
        ]);
        $featured_post = $featured_query->posts[0] ?? null;

        if (!$featured_post) {
            $fallback_query = new WP_Query([
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'post__not_in' => $legacy_sample_ids,
                'orderby' => 'date',
                'order' => 'DESC',
                'ignore_sticky_posts' => true,
                'no_found_rows' => true,
            ]);
            $featured_post = $fallback_query->posts[0] ?? null;
        }

        $featured_id = $featured_post ? (int) $featured_post->ID : 0;
        $archive_query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'post__not_in' => array_values(array_unique(array_merge($legacy_sample_ids, $featured_id ? [$featured_id] : []))),
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
        ]);
        $articles = is_array($archive_query->posts ?? null) ? $archive_query->posts : [];
        ?>
        <main class="blog-root blog-root--archive">
            <?php if ($featured_post) : ?>
                <?php
                $featured_url = (string) ts_blog_get_field('ts_blog_hero_image_url', $featured_id, '');
                $featured_alt = (string) ts_blog_get_field('ts_blog_hero_image_alt', $featured_id, get_the_title($featured_post));
                $featured_date = get_the_date('Y-m-d', $featured_post);
                $featured_category = ts_blog_primary_category($featured_id);
                ?>
                <section class="blog-featured-hero" aria-labelledby="ts-blog-featured-title">
                    <?php if ('' !== $featured_url) : ?>
                        <div class="blog-featured-bg">
                            <?php echo ts_blog_image_markup($featured_url, $featured_alt, 'blog-featured-image', 'eager', true); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                    <div class="blog-featured-overlay" aria-hidden="true"></div>
                    <div class="blog-featured-content">
                        <h1 class="blog-featured-title" id="ts-blog-featured-title"><?php echo esc_html(get_the_title($featured_post)); ?></h1>
                        <div class="blog-featured-meta">
                            <?php if ('' !== $featured_category) : ?><span><?php echo esc_html($featured_category); ?></span><span aria-hidden="true">|</span><?php endif; ?>
                            <time datetime="<?php echo esc_attr($featured_date); ?>"><?php echo esc_html(get_the_date('M j, Y', $featured_post)); ?></time>
                            <span aria-hidden="true">|</span>
                            <span><?php echo esc_html__('By ', 'tanzania-sensational') . esc_html((string) ts_blog_get_field('ts_blog_author_display', $featured_id, 'Tanzania Sensational')); ?></span>
                        </div>
                        <?php if (!empty($settings['featured_cta'])) : ?>
                            <a class="blog-ed-read blog-featured-read" href="<?php echo esc_url(get_permalink($featured_post)); ?>">
                                <?php echo esc_html($settings['featured_cta']); ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </section>
            <?php else : ?>
                <section class="blog-empty-state" role="status">
                    <h1><?php echo esc_html__('Trekker’s Journal', 'tanzania-sensational'); ?></h1>
                    <p><?php echo esc_html__('Stories and field notes will appear here when they are published.', 'tanzania-sensational'); ?></p>
                </section>
            <?php endif; ?>

            <section class="blog-editorial-grid" aria-label="<?php echo esc_attr__('Latest journal stories', 'tanzania-sensational'); ?>">
                <?php foreach ($articles as $article) : ?>
                    <?php
                    $article_id = (int) $article->ID;
                    $image_url = (string) ts_blog_get_field('ts_blog_hero_image_url', $article_id, '');
                    $image_alt = (string) ts_blog_get_field('ts_blog_hero_image_alt', $article_id, get_the_title($article));
                    $category = ts_blog_primary_category($article_id);
                    $published_date = get_the_date('Y-m-d', $article);
                    ?>
                    <article class="blog-ed-card">
                        <a class="blog-ed-img-wrap<?php echo '' === $image_url ? ' blog-ed-img-wrap--empty' : ''; ?>" href="<?php echo esc_url(get_permalink($article)); ?>" aria-label="<?php echo esc_attr(sprintf(__('Read %s', 'tanzania-sensational'), get_the_title($article))); ?>">
                            <?php if ('' !== $image_url) : ?>
                                <?php echo ts_blog_image_markup($image_url, $image_alt, 'blog-ed-image', 'lazy'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php endif; ?>
                        </a>
                        <div class="blog-ed-info">
                            <?php if ('' !== $category) : ?><span class="blog-ed-cat"><?php echo esc_html($category); ?></span><?php endif; ?>
                            <time class="blog-ed-date" datetime="<?php echo esc_attr($published_date); ?>"><?php echo esc_html(get_the_date('M j, Y', $article)); ?></time>
                            <h2 class="blog-ed-title"><a href="<?php echo esc_url(get_permalink($article)); ?>"><?php echo esc_html(get_the_title($article)); ?></a></h2>
                            <?php if ('yes' === ($settings['show_excerpts'] ?? 'yes')) : ?>
                                <?php $excerpt = get_the_excerpt($article); ?>
                                <?php if ('' !== trim((string) $excerpt)) : ?><p class="blog-ed-exc"><?php echo esc_html($excerpt); ?></p><?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($settings['card_cta'])) : ?>
                                <a class="blog-ed-read" href="<?php echo esc_url(get_permalink($article)); ?>">
                                    <?php echo esc_html($settings['card_cta']); ?>
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
                <?php if (!$articles) : ?>
                    <p class="blog-empty-state" role="status"><?php echo esc_html__('No other stories have been published yet.', 'tanzania-sensational'); ?></p>
                <?php endif; ?>
            </section>
        </main>
        <?php
    }
}
