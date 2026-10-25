/*
 * Hero motion. Two canvases:
 *  - stars: twinkling background stars with slight depth parallax.
 *  - flow: a few hundred glowing particles that spiral into the portal.
 * The cursor pushes particles aside, and scrolling speeds them up.
 * Everything pauses off screen, and reduced motion gets one still frame.
 */
( function () {
	'use strict';

	var sky = document.querySelector( '.atlas-sky' );
	if ( ! sky ) {
		return;
	}
	var starCv = sky.querySelector( 'canvas.stars' );
	var flowCv = sky.querySelector( 'canvas.flow' );
	var portal = sky.querySelector( '.atlas-portal' );
	if ( ! starCv || ! flowCv || ! starCv.getContext ) {
		return;
	}

	var sctx = starCv.getContext( '2d' );
	var fctx = flowCv.getContext( '2d' );
	var hero = sky.parentElement;
	var reduce = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var dpr = Math.min( window.devicePixelRatio || 1, 1.5 );
	var W = 0;
	var H = 0;
	var cx = 0;
	var cy = 0;
	var stars = [];
	var parts = [];
	var visible = true;
	var running = false;
	var px = 0;
	var py = 0;
	var tx = 0;
	var ty = 0;
	var mx = -9999;
	var my = -9999;
	var lastScroll = window.pageYOffset || 0;
	var warp = 1;
	var COLORS = [
		'rgba(122,63,214,0.35)',
		'rgba(140,90,230,0.6)',
		'rgba(180,140,245,0.85)',
		'rgba(235,225,255,1)'
	];

	function sizeCanvas( cv, ctx ) {
		cv.width = W * dpr;
		cv.height = H * dpr;
		cv.style.width = W + 'px';
		cv.style.height = H + 'px';
		ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );
	}

	function spawn( p, anywhere ) {
		var R = Math.max( W, H ) * ( anywhere ? 0.15 + Math.random() * 0.9 : 0.75 + Math.random() * 0.35 );
		var a = Math.random() * 6.2832;
		p.x = cx + Math.cos( a ) * R;
		p.y = cy + Math.sin( a ) * R * 0.78;
		p.px = p.x;
		p.py = p.y;
		p.s = 0.6 + Math.random() * 0.9;
	}

	function build() {
		var box = sky.getBoundingClientRect();
		W = Math.max( 1, Math.round( box.width ) );
		H = Math.max( 1, Math.round( box.height ) );
		sizeCanvas( starCv, sctx );
		sizeCanvas( flowCv, fctx );
		if ( portal ) {
			var pb = portal.getBoundingClientRect();
			cx = pb.left - box.left + pb.width / 2;
			cy = pb.top - box.top + pb.height / 2;
		} else {
			cx = W * 0.74;
			cy = H * 0.5;
		}
		var n = Math.round( Math.min( 900, ( W * H ) / 2600 ) );
		if ( W < 782 ) {
			n = Math.round( n * 0.5 );
		}
		parts = [];
		for ( var i = 0; i < n; i++ ) {
			var p = {};
			spawn( p, true );
			parts.push( p );
		}
		stars = [];
		var sc = Math.round( ( W * H ) / 7000 );
		for ( var j = 0; j < sc; j++ ) {
			var z = Math.random();
			stars.push( {
				x: Math.random() * W,
				y: Math.random() * H,
				z: z,
				r: 0.25 + z * 1.2,
				a: 0.2 + z * 0.65,
				t: Math.random() * 6.28,
				k: 0.5 + Math.random() * 1.5
			} );
		}
		fctx.clearRect( 0, 0, W, H );
		drawStars( 0 );
		if ( reduce ) {
			for ( var f = 0; f < 260; f++ ) {
				stepFlow( f, false );
			}
		}
	}

	function drawStars( t ) {
		sctx.clearRect( 0, 0, W, H );
		var sy = ( window.pageYOffset || 0 ) * 0.05;
		for ( var i = 0; i < stars.length; i++ ) {
			var s = stars[ i ];
			var tw = reduce ? 1 : 0.6 + 0.4 * Math.sin( t * 0.0012 * s.k + s.t );
			var y = ( s.y - sy * s.z * 6 + H * 4 ) % H;
			var x = s.x + px * s.z * -10;
			sctx.globalAlpha = s.a * tw;
			sctx.fillStyle = s.r > 0.9 ? '#c9b6f7' : '#f7f3e9';
			sctx.beginPath();
			sctx.arc( x, y, s.r, 0, 6.2832 );
			sctx.fill();
			if ( ! reduce ) {
				s.x -= 0.02 * s.z;
				if ( s.x < -2 ) {
					s.x = W + 2;
				}
			}
		}
		sctx.globalAlpha = 1;
	}

	function stepFlow( t, fade ) {
		if ( fade ) {
			fctx.globalCompositeOperation = 'destination-out';
			fctx.fillStyle = 'rgba(0,0,0,0.13)';
			fctx.fillRect( 0, 0, W, H );
			fctx.globalCompositeOperation = 'source-over';
		}
		var buckets = [ [], [], [], [] ];
		var span = Math.max( W * 0.34, 240 );
		var core = Math.min( W, H ) * 0.075;
		for ( var i = 0; i < parts.length; i++ ) {
			var p = parts[ i ];
			var dx = cx - p.x;
			var dy = cy - p.y;
			var r = Math.sqrt( dx * dx + dy * dy ) || 1;
			var near = Math.exp( -r / ( H * 0.34 ) );
			var tang = ( 0.7 + 3.4 * near ) * p.s * warp;
			var inw = ( 0.18 + 1.0 * near ) * p.s * warp;
			var nz = Math.sin( p.x * 0.004 + t * 0.0004 ) + Math.cos( p.y * 0.005 - t * 0.0005 );
			var vx = ( -dy / r ) * tang + ( dx / r ) * inw + nz * 0.35;
			var vy = ( dx / r ) * tang * 0.8 + ( dy / r ) * inw + nz * 0.25;
			var md = Math.sqrt( ( p.x - mx ) * ( p.x - mx ) + ( p.y - my ) * ( p.y - my ) );
			if ( md < 190 ) {
				var k = ( 1 - md / 190 ) * 2.6;
				vx += ( ( p.x - mx ) / ( md || 1 ) ) * k;
				vy += ( ( p.y - my ) / ( md || 1 ) ) * k;
			}
			p.px = p.x;
			p.py = p.y;
			p.x += vx;
			p.y += vy;
			if ( r < core || p.x < -60 || p.x > W + 60 || p.y < -60 || p.y > H + 60 ) {
				spawn( p, false );
				continue;
			}
			var a = 0.1 + 0.9 * Math.exp( -r / span );
			var b = Math.min( 3, Math.floor( a * 4 ) );
			buckets[ b ].push( p );
		}
		fctx.lineCap = 'round';
		for ( var q = 0; q < 4; q++ ) {
			var list = buckets[ q ];
			if ( ! list.length ) {
				continue;
			}
			fctx.strokeStyle = COLORS[ q ];
			fctx.lineWidth = 0.7 + q * 0.5;
			fctx.beginPath();
			for ( var m = 0; m < list.length; m++ ) {
				fctx.moveTo( list[ m ].px, list[ m ].py );
				fctx.lineTo( list[ m ].x, list[ m ].y );
			}
			fctx.stroke();
		}
	}

	function frame( t ) {
		if ( ! visible || document.hidden ) {
			running = false;
			return;
		}
		var sc = window.pageYOffset || 0;
		var dv = Math.abs( sc - lastScroll );
		lastScroll = sc;
		warp += ( Math.min( 3.5, 1 + dv * 0.12 ) - warp ) * 0.08;
		px += ( tx - px ) * 0.05;
		py += ( ty - py ) * 0.05;
		sky.style.setProperty( '--px', px.toFixed( 3 ) );
		sky.style.setProperty( '--py', py.toFixed( 3 ) );
		drawStars( t );
		stepFlow( t, true );
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
		var box = hero.getBoundingClientRect();
		mx = e.clientX - box.left;
		my = e.clientY - box.top;
		tx = ( mx / box.width - 0.5 ) * 2;
		ty = ( my / box.height - 0.5 ) * 2;
		sky.style.setProperty( '--mx', mx + 'px' );
		sky.style.setProperty( '--my', my + 'px' );
	} );
	hero.addEventListener( 'pointerleave', function () {
		mx = -9999;
		my = -9999;
		tx = 0;
		ty = 0;
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
