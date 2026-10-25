/*
 * Sitewide motion.
 *  1. Sub-page heroes (.atlas-subhero) get a canvas sky. The mode comes from a
 *     class: atlas-m-rise (embers drift up), atlas-m-fall (streaks fall, like
 *     a descent) or atlas-m-link (a constellation that reaches for the cursor).
 *  2. Cards and section headings fade up once as they scroll into view.
 * Reduced motion gets a still sky and no reveal animation.
 */
( function () {
	'use strict';

	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------- 1. Sub-page sky ---------- */
	function initSky( hero ) {
		var mode = /atlas-m-(rise|fall|link)/.exec( hero.className );
		mode = mode ? mode[ 1 ] : 'rise';

		var sky = document.createElement( 'div' );
		sky.className = 'atlas-sky atlas-sky--sub';
		sky.setAttribute( 'aria-hidden', 'true' );
		sky.innerHTML = '<canvas></canvas><div class="atlas-orb"></div>';
		hero.insertBefore( sky, hero.firstChild );

		var cv = sky.querySelector( 'canvas' );
		var ctx = cv.getContext( '2d' );
		var dpr = Math.min( window.devicePixelRatio || 1, 1.5 );
		var W = 0;
		var H = 0;
		var parts = [];
		var mx = -9999;
		var my = -9999;
		var visible = true;
		var running = false;

		function make( p, anywhere ) {
			p.x = Math.random() * W;
			p.z = Math.random();
			p.r = 0.6 + p.z * 2.2;
			p.ph = Math.random() * 6.28;
			if ( mode === 'rise' ) {
				p.y = anywhere ? Math.random() * H : H + 10;
				p.vy = -( 0.25 + p.z * 0.7 );
			} else if ( mode === 'fall' ) {
				p.y = anywhere ? Math.random() * H : -20;
				p.vy = 0.8 + p.z * 2.4;
				p.len = 20 + p.z * 70;
			} else {
				p.y = Math.random() * H;
				p.vx = ( Math.random() - 0.5 ) * 0.28;
				p.vy = ( Math.random() - 0.5 ) * 0.28;
			}
		}

		function build() {
			var b = hero.getBoundingClientRect();
			W = Math.max( 1, Math.round( b.width ) );
			H = Math.max( 1, Math.round( b.height ) );
			cv.width = W * dpr;
			cv.height = H * dpr;
			cv.style.width = W + 'px';
			cv.style.height = H + 'px';
			ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );
			var n = Math.round( ( W * H ) / ( mode === 'link' ? 14000 : mode === 'fall' ? 16000 : 11000 ) );
			n = Math.min( n, W < 782 ? 40 : 110 );
			parts = [];
			for ( var i = 0; i < n; i++ ) {
				var p = {};
				make( p, true );
				parts.push( p );
			}
			draw( 0 );
		}

		function draw( t ) {
			ctx.clearRect( 0, 0, W, H );
			var i;
			var p;
			if ( mode === 'rise' ) {
				for ( i = 0; i < parts.length; i++ ) {
					p = parts[ i ];
					var sx = p.x + Math.sin( t * 0.0006 + p.ph ) * 18 * p.z;
					var g = ctx.createRadialGradient( sx, p.y, 0, sx, p.y, p.r * 5 );
					g.addColorStop( 0, 'rgba(210,190,255,' + ( 0.35 + p.z * 0.5 ) + ')' );
					g.addColorStop( 0.35, 'rgba(150,100,235,' + ( 0.18 + p.z * 0.2 ) + ')' );
					g.addColorStop( 1, 'rgba(122,63,214,0)' );
					ctx.fillStyle = g;
					ctx.fillRect( sx - p.r * 5, p.y - p.r * 5, p.r * 10, p.r * 10 );
					if ( ! reduce ) {
						p.y += p.vy;
						if ( p.y < -20 ) {
							make( p, false );
						}
					}
				}
			} else if ( mode === 'fall' ) {
				ctx.lineCap = 'round';
				for ( i = 0; i < parts.length; i++ ) {
					p = parts[ i ];
					var gr = ctx.createLinearGradient( p.x, p.y - p.len, p.x, p.y );
					gr.addColorStop( 0, 'rgba(150,100,235,0)' );
					gr.addColorStop( 1, 'rgba(215,200,255,' + ( 0.25 + p.z * 0.6 ) + ')' );
					ctx.strokeStyle = gr;
					ctx.lineWidth = 0.6 + p.z * 1.1;
					ctx.beginPath();
					ctx.moveTo( p.x, p.y - p.len );
					ctx.lineTo( p.x, p.y );
					ctx.stroke();
					if ( ! reduce ) {
						p.y += p.vy;
						if ( p.y - p.len > H ) {
							make( p, false );
						}
					}
				}
			} else {
				for ( i = 0; i < parts.length; i++ ) {
					p = parts[ i ];
					if ( ! reduce ) {
						p.x += p.vx;
						p.y += p.vy;
						if ( p.x < 0 || p.x > W ) {
							p.vx *= -1;
						}
						if ( p.y < 0 || p.y > H ) {
							p.vy *= -1;
						}
					}
					ctx.fillStyle = 'rgba(215,200,255,' + ( 0.35 + p.z * 0.55 ) + ')';
					ctx.beginPath();
					ctx.arc( p.x, p.y, 0.8 + p.z * 1.4, 0, 6.2832 );
					ctx.fill();
					for ( var j = i + 1; j < parts.length; j++ ) {
						var q = parts[ j ];
						var d = Math.hypot( p.x - q.x, p.y - q.y );
						if ( d < 140 ) {
							ctx.strokeStyle = 'rgba(160,115,240,' + ( ( 1 - d / 140 ) * 0.4 ) + ')';
							ctx.lineWidth = 0.7;
							ctx.beginPath();
							ctx.moveTo( p.x, p.y );
							ctx.lineTo( q.x, q.y );
							ctx.stroke();
						}
					}
					var dm = Math.hypot( p.x - mx, p.y - my );
					if ( dm < 190 ) {
						ctx.strokeStyle = 'rgba(230,215,255,' + ( ( 1 - dm / 190 ) * 0.7 ) + ')';
						ctx.lineWidth = 0.9;
						ctx.beginPath();
						ctx.moveTo( p.x, p.y );
						ctx.lineTo( mx, my );
						ctx.stroke();
					}
				}
			}
		}

		function frame( t ) {
			if ( ! visible || document.hidden ) {
				running = false;
				return;
			}
			draw( t );
			window.requestAnimationFrame( frame );
		}

		function start() {
			if ( reduce || running ) {
				return;
			}
			running = true;
			window.requestAnimationFrame( frame );
		}

		build();
		window.addEventListener( 'resize', build );
		if ( reduce ) {
			return;
		}
		hero.addEventListener( 'pointermove', function ( e ) {
			var b = hero.getBoundingClientRect();
			mx = e.clientX - b.left;
			my = e.clientY - b.top;
			sky.style.setProperty( '--mx', mx + 'px' );
			sky.style.setProperty( '--my', my + 'px' );
		} );
		hero.addEventListener( 'pointerleave', function () {
			mx = -9999;
			my = -9999;
		} );
		if ( 'IntersectionObserver' in window ) {
			new IntersectionObserver( function ( en ) {
				visible = en[ 0 ].isIntersecting;
				if ( visible ) {
					start();
				}
			} ).observe( hero );
		}
		document.addEventListener( 'visibilitychange', start );
		start();
	}

	var heroes = document.querySelectorAll( '.atlas-subhero' );
	for ( var h = 0; h < heroes.length; h++ ) {
		initSky( heroes[ h ] );
	}

	/* ---------- 2. Scroll reveal ---------- */
	if ( reduce || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}
	var sel = '[class*="atlas-card"], .atlas-book-grid > *, .atlas-social-grid > *, .atlas-principles > *, .atlas-facts, .atlas-promo, .atlas-doors h2, main h2.wp-block-heading';
	var nodes = document.querySelectorAll( sel );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( en ) {
			if ( en.isIntersecting ) {
				var el = en.target;
				el.classList.add( 'is-in' );
				io.unobserve( el );
				window.setTimeout( function () {
					el.classList.remove( 'atlas-rv', 'is-in' );
					el.style.transitionDelay = '';
				}, 1200 );
			}
		} );
	}, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' } );

	document.documentElement.classList.add( 'js-reveal' );
	for ( var n = 0; n < nodes.length; n++ ) {
		var node = nodes[ n ];
		if ( node.closest( '.atlas-hero' ) || node.closest( '.atlas-subhero' ) || node.closest( 'header' ) ) {
			continue;
		}
		var idx = Array.prototype.indexOf.call( node.parentNode.children, node );
		node.style.transitionDelay = Math.min( idx, 5 ) * 0.07 + 's';
		node.classList.add( 'atlas-rv' );
		io.observe( node );
	}
}() );
