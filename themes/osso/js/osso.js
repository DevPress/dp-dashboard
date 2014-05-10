/**
 * osso admin theme jQuery.
 */
$j = jQuery.noConflict();

$j( window ).load(

	function() {
	
		$j( '<div id="admin-menu-toggle">' + osso_scripts.main_menu + '</div>' ).prependTo( '#wpwrap' );
		$j( '#admin-menu-toggle' ).click(function() {
			$j( '#adminmenuback' ).toggleClass( 'visible' );
		});
	
		/* clear DIV after page title */
		$j( '#wpbody-content .wrap h2:first-of-type' ).after('<div class="clear"></div>');
	
		/* add menu toggle to menu items with submenu */
		$j( '#adminmenu li.wp-has-submenu:not(.wp-has-current-submenu) > a' ).before('<div class="submenu-toggle"></div>');
		
		/* toggle class when submenu toggle is clicked */
		$j( '#collapse-menu' ).click(function() {
			$j( '#adminmenu' ).toggleClass( 'visible' );
		});
	
		/* toggle class when submenu toggle is clicked */
		$j( '#adminmenu li.wp-has-submenu > .submenu-toggle' ).click(function() {
			$j(this).toggleClass( 'opened' );
			$j(this).siblings( '.wp-submenu' ).toggleClass( 'visible' );
		});
		
		/* strip parentheses around selected elements */
		$j( ' #wpbody-content .subsubsub li a span.count, #dashboard_plugins .inside h5 + span ').each( function() {
			var currentCount = $j( this ).html();
			var newCount = currentCount.substring(1, currentCount.length-1);
			$j( this ).html( newCount );
		});
		
		/**
		 * Metabox Shortcuts Menu
		 ************************************************/
		
		if( $j( 'body' ).hasClass( 'index-php' ) ) {
		
			$j( '#dashboard-widgets-wrap' ).before( '<ul id="metabox-shortcuts" class="subsubsub"></ul>');
			
			$j( '#dashboard-widgets .postbox:visible ' ).each( function(index) {
			
				var metaboxID = $j( this ).attr( 'id' );
				var metaboxText = $j( this ).children( '.hndle').children().text();
				
				// the "Configure" text from the configure link is unfortunately attached to the string we're trying to grab so strip it out
				// but in other languages, this text will be something different so localize "Configure" through functions.php then search for the localized version before replacing it with nothing
				var metaboxNewText = metaboxText.replace( osso_scripts.configure, '');
				
				$j( '<li><a href="#' + metaboxID + '">' + metaboxNewText + '</a></li>' ).appendTo( '#metabox-shortcuts' );
			
			});
			
			$j( '<li><a href="#wpwrap" class="back-to-top">' + osso_scripts.back_to_top + '</a></li>' ).appendTo( '#metabox-shortcuts' );
		
		}
		
		if( $j( 'body' ).is( '.post-new-php, .post-php, .link-add-php' ) ) {
		
			$j( '#poststuff' ).before( '<ul id="metabox-shortcuts" class="subsubsub"></ul>');
			
			$j( '#post-body .postbox:visible ' ).each( function(index) {
			
				var metaboxID = $j( this ).attr( 'id' );
				var metaboxText = $j( this ).children( '.hndle').children().text();
				var metaboxNewText = metaboxText.replace( osso_scripts.configure, '');
				
				$j( '<li><a href="#' + metaboxID + '">' + metaboxNewText + '</a></li>' ).appendTo( '#metabox-shortcuts' );
			
			});
				
			$j( '<li><a href="#wpwrap" class="back-to-top">' + osso_scripts.back_to_top + '</a></li>' ).appendTo( '#metabox-shortcuts' );
		
		}
		
		/**
		 * Sticky Shortcuts Menu or Subsubsub list
		 ************************************************/
		// Thanks to http://andrewhenderson.me/tutorial/jquery-sticky-sidebar/
		if (!!$j( '.subsubsub' ).offset()) { // make sure ".subsubsub" element exists
 
			var stickyTop = $j( '.subsubsub' ).offset().top; // returns number
	 
			$j( window ).scroll( function(){ // scroll event
	 
				var windowTop = $j( window ).scrollTop(); // returns number
	 
				if ( stickyTop < windowTop ){
					$j( '.subsubsub' ).addClass( 'pinned' );
					}
				else {
					$j( '.subsubsub' ).removeClass( 'pinned' );
				}
	 
			});
 
		}
		
		/**
		 * Widgets Page
		 ************************************************/
		 
		// For each "widget-holder", use it as an div ID and add a number after the ID.
		$j( '#widgets-left .widgets-holder-wrap').each( function(index, value) {
			var num = index + 1;
			$j( value ).attr( 'id', 'widget-holder-'+ num);
		});
		
		// Add tabs
		$j( '#widgets-left' ).addClass( 'ui-tabs' ).prepend( '<ul class="ui-tabs-nav"></ul>').prepend( '<h3 class="inserted-title widgets-holder-title">' + osso_scripts.from + '</h3>');
		
		$j( '#widgets-left .widgets-holder-wrap').each( function(index) {
		
			var tabID = $j( this ).attr( 'id' );
			var tabText = $j( this ).children( '.sidebar-name' ).children( 'h3' ).clone().children().remove().end().text();
		
			$j( '<li><a href="#' + tabID + '">' + tabText + '</a></li>' ).appendTo( '.ui-tabs-nav' );
		
		});

		// Enqueue ui-tabs on Menus and Widgets pages
		if( $j( 'body' ).is( '.widgets-php' ) ) {
			$j( '.ui-tabs' ).tabs();
		
		}

	}

);