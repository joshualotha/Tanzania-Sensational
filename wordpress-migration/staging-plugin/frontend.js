( function() {
    'use strict';

    function ready( callback ) {
        if ( document.readyState === 'loading' ) {
            document.addEventListener( 'DOMContentLoaded', callback, { once: true } );
        } else {
            callback();
        }
    }

    ready( function() {
        const navbar = document.getElementById( 'navbar' );
        const hamburger = navbar?.querySelector( '.mobile-hamburger' );
        const mobileBreakpoint = window.matchMedia( '(max-width: 900px)' );

        if ( navbar && hamburger ) {
            const drawer = document.getElementById( 'ts-mobile-drawer' );
            hamburger.setAttribute( 'aria-expanded', 'false' );
            hamburger.setAttribute( 'aria-controls', 'ts-primary-navigation' );
            const navLinks = navbar.querySelector( '.nav-links' );
            navLinks?.setAttribute( 'id', 'ts-primary-navigation' );

            const closeMenu = function() {
                navbar.classList.remove( 'mobile-open' );
                hamburger.classList.remove( 'open' );
                hamburger.setAttribute( 'aria-expanded', 'false' );
                document.body.classList.remove( 'ts-menu-open' );
                drawer?.classList.remove( 'is-open' );
                drawer?.setAttribute( 'aria-hidden', 'true' );
                drawer?.querySelectorAll( '.expanded, .mobile-drawer-content.is-open' ).forEach( function( item ) { item.classList.remove( 'expanded', 'is-open' ); } );
                navbar.querySelectorAll( '.mobile-active' ).forEach( function( item ) {
                    item.classList.remove( 'mobile-active' );
                } );
            };

            hamburger.addEventListener( 'click', function() {
                const open = ! navbar.classList.contains( 'mobile-open' );
                closeMenu();
                if ( open ) {
                    navbar.classList.add( 'mobile-open' );
                    hamburger.classList.add( 'open' );
                    hamburger.setAttribute( 'aria-expanded', 'true' );
                    document.body.classList.add( 'ts-menu-open' );
                    drawer?.classList.add( 'is-open' );
                    drawer?.setAttribute( 'aria-hidden', 'false' );
                }
            } );

            drawer?.querySelector( '.mobile-drawer-close' )?.addEventListener( 'click', closeMenu );
            drawer?.querySelector( '.mobile-drawer-backdrop' )?.addEventListener( 'click', closeMenu );
            drawer?.querySelectorAll( '[data-ts-drawer-toggle]' ).forEach( function( toggle ) {
                toggle.addEventListener( 'click', function() {
                    const content = drawer.querySelector( '[data-ts-drawer-content="' + toggle.dataset.tsDrawerToggle + '"]' );
                    const open = ! toggle.classList.contains( 'expanded' );
                    toggle.classList.toggle( 'expanded', open );
                    content?.classList.toggle( 'is-open', open );
                } );
            } );
            drawer?.querySelectorAll( 'a' ).forEach( function( link ) { link.addEventListener( 'click', closeMenu ); } );

            navbar.querySelectorAll( '.mega-dropdown > .dropdown-toggle' ).forEach( function( toggle ) {
                toggle.addEventListener( 'click', function( event ) {
                    if ( ! mobileBreakpoint.matches ) return;
                    event.preventDefault();
                    const item = toggle.closest( '.mega-dropdown' );
                    const wasOpen = item.classList.contains( 'mobile-active' );
                    navbar.querySelectorAll( '.mega-dropdown.mobile-active' ).forEach( function( sibling ) {
                        sibling.classList.remove( 'mobile-active' );
                    } );
                    if ( ! wasOpen ) item.classList.add( 'mobile-active' );
                } );
            } );

            navbar.querySelectorAll( '.mega-menu a, .nav-links > li:not(.mega-dropdown) a, .nav-cta' ).forEach( function( link ) {
                link.addEventListener( 'click', closeMenu );
            } );

            document.addEventListener( 'keydown', function( event ) {
                if ( event.key === 'Escape' ) closeMenu();
            } );

            mobileBreakpoint.addEventListener?.( 'change', function( event ) {
                if ( ! event.matches ) closeMenu();
            } );
        }

        const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
        const revealItems = document.querySelectorAll( '.reveal' );
        if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
            revealItems.forEach( function( item ) { item.classList.add( 'visible' ); } );
        } else {
            const observer = new IntersectionObserver( function( entries ) {
                entries.forEach( function( entry ) {
                    if ( entry.isIntersecting ) {
                        entry.target.classList.add( 'visible' );
                        observer.unobserve( entry.target );
                    }
                } );
            }, { threshold: 0.12, rootMargin: '0px 0px -40px' } );
            revealItems.forEach( function( item ) { observer.observe( item ); } );
        }

		document.querySelectorAll( '[data-ts-booking-form]' ).forEach( function( form ) {
			form.addEventListener( 'submit', async function( event ) {
				event.preventDefault();
				const message = form.querySelector( '[data-ts-booking-message]' );
				const button = form.querySelector( 'button[type="submit"]' );
				const originalLabel = button.textContent;
				const payload = Object.fromEntries( new FormData( form ).entries() );
				payload.group_size = Number( payload.group_size );
				payload.tour_post_id = Number( payload.tour_post_id );
				message.className = 'ts-booking-message';
				message.textContent = '';
				button.disabled = true;
				button.textContent = 'Sending…';

				try {
					const response = await fetch( form.dataset.endpoint, {
						method: 'POST',
						headers: { 'Content-Type': 'application/json' },
						body: JSON.stringify( payload )
					} );
					const result = await response.json();
					if ( ! response.ok ) throw new Error( result.message || 'We could not send your request.' );
					message.classList.add( 'is-success' );
					message.textContent = result.message + ' Reference: ' + result.booking_ref;
					form.reset();
				} catch ( error ) {
					message.classList.add( 'is-error' );
					message.textContent = error.message || 'We could not send your request. Please try again.';
				} finally {
					button.disabled = false;
					button.textContent = originalLabel;
				}
			} );
		} );
    } );
}() );
