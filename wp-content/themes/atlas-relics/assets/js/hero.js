/*
 * Hero motion: a slow drifting star field on a canvas, plus a small pointer
 * parallax on the ribbon layer. Pauses when the hero is off screen or the tab
 * is hidden, and draws one still frame for visitors who prefer reduced motion.
 */
( function () {
	'use strict';

	var sky = document.querySelector( '.atlas-sky' );
	var canvas = sky && sky.querySelector( 'canvas' );
	if ( ! canvas || ! canvas.getContext ) {
		return;
	}

	var ctx = canvas.getContext( '2d' );
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var stars = [];
	var width = 0;
	var height = 0;
	var dpr = Math.min( window.devicePixelRatio || 1, 2 );
	var visible = true;
	var running = false;
	var px = 0;
	var py = 0;
	var tx = 0;
	var ty = 0;

	function seed() {
		var count = Math.round( ( width * height ) / 11000 );
		stars = [];
		for ( var i = 0; i < count; i++ ) {
			stars.push( {
				x: Math.random() * width,
				y: Math.random() * height,
				r: 0.3 + Math.random() * 1.1,
				a: 0.18 + Math.random() * 0.6,
				vy: -( 0.02 + Math.random() * 0.06 ),
				vx: ( Math.random() - 0.5 ) * 0.03,
				p: Math.random() * Math.PI * 2,
				s: 0.4 + Math.random() * 1.2
			} );
		}
	}

	function resize() {
		var box = sky.getBoundingClientRect();
		width = Math.max( 1, Math.round( box.width ) );
		height = Math.max( 1, Math.round( box.height ) );
		canvas.width = width * dpr;
		canvas.height = height * dpr;
		canvas.style.width = width + 'px';
		canvas.style.height = height + 'px';
		ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );
		seed();
		draw( 0 );
	}

	function draw( t ) {
		ctx.clearRect( 0, 0, width, height );
		for ( var i = 0; i < stars.length; i++ ) {
			var s = stars[ i ];
			var tw = reduce ? 1 : 0.65 + 0.35 * Math.sin( t * 0.001 * s.s + s.p );
			ctx.globalAlpha = s.a * tw;
			ctx.fillStyle = s.r > 0.95 ? '#c9b6f7' : '#f7f3e9';
			ctx.beginPath();
			ctx.arc( s.x, s.y, s.r, 0, 6.2832 );
			ctx.fill();
			if ( ! reduce ) {
				s.x += s.vx;
				s.y += s.vy;
				if ( s.y < -2 ) {
					s.y = height + 2;
					s.x = Math.random() * width;
				}
				if ( s.x < -2 ) {
					s.x = width + 2;
				} else if ( s.x > width + 2 ) {
					s.x = -2;
				}
			}
		}
		ctx.globalAlpha = 1;
	}

	function frame( t ) {
		if ( ! visible || document.hidden ) {
			running = false;
			return;
		}
		draw( t );
		px += ( tx - px ) * 0.05;
		py += ( ty - py ) * 0.05;
		sky.style.setProperty( '--px', px.toFixed( 3 ) );
		sky.style.setProperty( '--py', py.toFixed( 3 ) );
		window.requestAnimationFrame( frame );
	}

	function start() {
		if ( reduce || running ) {
			return;
		}
		running = true;
		window.requestAnimationFrame( frame );
	}

	resize();
	window.addEventListener( 'resize', resize );

	if ( reduce ) {
		return;
	}

	var hero = sky.parentElement;
	hero.addEventListener( 'pointermove', function ( e ) {
		var box = hero.getBoundingClientRect();
		tx = ( ( e.clientX - box.left ) / box.width - 0.5 ) * 2;
		ty = ( ( e.clientY - box.top ) / box.height - 0.5 ) * 2;
	} );

	if ( 'IntersectionObserver' in window ) {
		new IntersectionObserver( function ( entries ) {
			visible = entries[ 0 ].isIntersecting;
			if ( visible ) {
				start();
			}
		} ).observe( hero );
	}
	document.addEventListener( 'visibilitychange', start );
	start();
}() );
