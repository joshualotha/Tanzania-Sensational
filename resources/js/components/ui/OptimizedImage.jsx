import { useMemo } from 'react';

/**
 * OptimizedImage — responsive image component with WebP support and srcSet.
 *
 * Features:
 * - Unsplash URLs: auto-generates srcSet at 400w, 800w, 1200w, 1600w using Unsplash's `w` param
 * - Local images: renders as-is with loading="lazy" and decoding="async"
 * - Consistent loading="lazy" (except when priority={true})
 * - Consistent alt text handling
 * - Proper aspect ratio placeholder via optional aspectRatio prop
 *
 * Usage:
 *   <OptimizedImage
 *     src="https://images.unsplash.com/photo-xxx?auto=format&fit=crop&q=80"
 *     alt="Descriptive alt text"
 *     className="my-custom-class"
 *     priority={false}    // set true for hero/LCP images
 *     aspectRatio="16/9"  // optional CSS aspect-ratio
 *     sizes="(max-width: 768px) 100vw, 50vw"  // responsive sizes
 *   />
 */
export default function OptimizedImage({
    src,
    alt = '',
    className = '',
    priority = false,
    aspectRatio = null,
    sizes = '100vw',
    style = {},
    ...rest
}) {
    const isUnsplash = useMemo(() => {
        if (!src) return false;
        try {
            return new URL(src).hostname === 'images.unsplash.com';
        } catch {
            return false;
        }
    }, [src]);

    // Generate srcSet for Unsplash images at multiple widths
    const srcSet = useMemo(() => {
        if (!isUnsplash || !src) return undefined;

        const widths = [400, 800, 1200, 1600];
        // Remove existing w param if present, then add our own
        const base = src.replace(/&w=\d+/g, '').replace(/w=\d+/, '');
        const separator = base.includes('?') ? '&' : '?';

        return widths
            .map((w) => `${base}${separator}w=${w} ${w}w`)
            .join(', ');
    }, [isUnsplash, src]);

    // For Unsplash, ensure auto=format is present (enables WebP)
    const optimizedSrc = useMemo(() => {
        if (!isUnsplash || !src) return src;
        if (src.includes('auto=format')) return src;
        const separator = src.includes('?') ? '&' : '?';
        return `${src}${separator}auto=format`;
    }, [isUnsplash, src]);

    const imgStyle = {
        ...style,
        ...(aspectRatio ? { aspectRatio } : {}),
    };

    return (
        <img
            src={optimizedSrc || src}
            srcSet={srcSet}
            sizes={srcSet ? sizes : undefined}
            alt={alt}
            className={className}
            loading={priority ? undefined : 'lazy'}
            decoding={priority ? undefined : 'async'}
            fetchpriority={priority ? 'high' : undefined}
            style={imgStyle}
            {...rest}
        />
    );
}
