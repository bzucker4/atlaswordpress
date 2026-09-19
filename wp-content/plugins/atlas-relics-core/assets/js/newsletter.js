/**
 * Submits every ".atlas-relics-newsletter-form" via AJAX instead of a full
 * page reload, and reports the result in that form's own
 * ".atlas-relics-newsletter-message" element.
 */
( function () {
	'use strict';

	function handleSubmit( event ) {
		event.preventDefault();

		var form = event.target;
		var emailField = form.querySelector( 'input[type="email"]' );
		var messageEl = form.querySelector( '.atlas-relics-newsletter-message' );
		var submitButton = form.querySelector( 'button[type="submit"]' );

		if ( ! emailField || ! window.atlasRelicsNewsletter ) {
			return;
		}

		if ( submitButton ) {
			submitButton.disabled = true;
		}

		if ( messageEl ) {
			messageEl.textContent = '';
		}

		var body = new URLSearchParams();
		body.set( 'action', 'atlas_relics_newsletter_signup' );
		body.set( 'nonce', window.atlasRelicsNewsletter.nonce );
		body.set( 'email', emailField.value );
		body.set( 'segment', form.getAttribute( 'data-segment' ) || 'footer' );

		fetch( window.atlasRelicsNewsletter.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString(),
		} )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( result ) {
				if ( messageEl ) {
					messageEl.textContent = result && result.data && result.data.message
						? result.data.message
						: '';
				}
				if ( result && result.success ) {
					form.reset();
				}
			} )
			.catch( function () {
				if ( messageEl ) {
					messageEl.textContent = 'Something went wrong. Please try again.';
				}
			} )
			.finally( function () {
				if ( submitButton ) {
					submitButton.disabled = false;
				}
			} );
	}

	document.addEventListener( 'DOMContentLoaded', function () {
		var forms = document.querySelectorAll( '.atlas-relics-newsletter-form' );
		for ( var i = 0; i < forms.length; i++ ) {
			forms[ i ].addEventListener( 'submit', handleSubmit );
		}
	} );
} )();
