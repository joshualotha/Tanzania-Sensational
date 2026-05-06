import { Link } from '@inertiajs/react';

export default function NotFound() {
    return (
        <div style={{
            minHeight: '100vh',
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
            justifyContent: 'center',
            background: '#070707',
            color: 'white',
            fontFamily: 'Outfit, sans-serif',
            textAlign: 'center',
            padding: '2rem',
        }}>
            <h1 style={{
                fontSize: 'clamp(4rem, 12vw, 8rem)',
                fontWeight: 700,
                color: 'var(--gold, #C9A84C)',
                margin: 0,
                lineHeight: 1,
                letterSpacing: '0.05em',
            }}>404</h1>
            <p style={{
                fontSize: 'clamp(1.1rem, 3vw, 1.5rem)',
                opacity: 0.8,
                marginTop: '1rem',
                maxWidth: 500,
                lineHeight: 1.6,
            }}>
                The page you're looking for doesn't exist or has been moved.
            </p>
            <div style={{ marginTop: '2rem', display: 'flex', gap: '1rem', flexWrap: 'wrap', justifyContent: 'center' }}>
                <Link
                    href="/"
                    style={{
                        background: 'var(--gold, #C9A84C)',
                        color: '#111',
                        padding: '0.85rem 2rem',
                        textDecoration: 'none',
                        fontWeight: 600,
                        borderRadius: 4,
                        fontSize: '0.95rem',
                        letterSpacing: '0.04em',
                    }}
                >
                    Back to Home
                </Link>
                <Link
                    href="/contact"
                    style={{
                        background: 'transparent',
                        border: '1px solid rgba(255,255,255,0.2)',
                        color: 'white',
                        padding: '0.85rem 2rem',
                        textDecoration: 'none',
                        fontWeight: 600,
                        borderRadius: 4,
                        fontSize: '0.95rem',
                        letterSpacing: '0.04em',
                    }}
                >
                    Contact Us
                </Link>
            </div>
        </div>
    );
}
