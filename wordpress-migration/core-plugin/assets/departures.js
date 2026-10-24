( function() {
	'use strict';
	document.addEventListener( 'DOMContentLoaded', function() {
		const panel = document.getElementById( 'ts-departure-booking' );
		const form = document.querySelector( '[data-ts-departure-form]' );
		if ( ! panel || ! form ) return;
		const departureButtons = document.querySelectorAll( '[data-departure-id]' );
		departureButtons.forEach( function( button ) {
			button.addEventListener( 'click', function() {
				form.elements.departure_id.value = button.dataset.departureId;
				panel.querySelector( '[data-ts-selected-departure]' ).textContent = button.dataset.departureLabel;
				panel.hidden = false;
				panel.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			} );
		} );
		const requestedDepartureId = new URLSearchParams( window.location.search ).get( 'departure_id' );
		const requestedDeparture = Array.from( departureButtons ).find( function( button ) {
			return button.dataset.departureId === requestedDepartureId;
		} );
		if ( requestedDeparture ) requestedDeparture.click();
		form.addEventListener( 'submit', async function( event ) {
			event.preventDefault();
			const message = form.querySelector( '[data-ts-departure-message]' );
			const button = form.querySelector( 'button[type="submit"]' );
			const label = button.textContent;
			const payload = Object.fromEntries( new FormData( form ).entries() );
			payload.departure_id = Number( payload.departure_id );
			payload.group_size = Number( payload.group_size );
			button.disabled = true;
			button.textContent = 'Sending…';
			message.className = '';
			message.textContent = '';
			try {
				const response = await fetch( form.dataset.endpoint, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify( payload ) } );
				const result = await response.json();
				if ( ! response.ok ) throw new Error( result.message || 'We could not send your request.' );
				message.className = 'is-success';
				message.textContent = result.message + ' Reference: ' + result.booking_ref;
				form.querySelectorAll( 'input:not([type="hidden"]), textarea' ).forEach( function( field ) { field.value = ''; } );
			} catch ( error ) {
				message.className = 'is-error';
				message.textContent = error.message || 'We could not send your request. Please try again.';
			} finally {
				button.disabled = false;
				button.textContent = label;
			}
		} );
	} );
}() );
