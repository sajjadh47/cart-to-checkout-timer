jQuery( document ).ready( function( $ ) {
	// Mutation observer for dynamic block loading
	var observer = new MutationObserver( function( mutations ) {
		mutations.forEach( function( mutation ) {
			$( mutation.addedNodes ).each( function() {
				// Look for the specific element in legacy non-block based themes
				var $addedToCartElement = $( this ).find( 'dd.variation-AddedToCart' );

				if ( $addedToCartElement.length ) {
					$addedToCartElement.each( function( index, element ) {
						// Find the text element for this specific element
						var $textElement = $( element ).find( 'p' );

						if ( $textElement.length ) {
							// Start the live timer for this element
							startLiveTimer( $textElement );
						}
					} );
				}

				// Find the target block within the newly added nodes
				var $addedToCartBlock = $( this ).find( '.wc-block-components-product-details__added-to-cart' );

				if ( $addedToCartBlock.length ) {
					$addedToCartBlock.each( function( index, block ) {
						// Find the text element for this specific block
						var $textElement = $( block ).find( '.wc-block-components-product-details__value' );

						if ( $textElement.length ) {
							// Start the live timer for this element
							startLiveTimer( $textElement );
						}
					} );
				}
			} );
		} );
	} );

	// Start observing the body for added nodes
	observer.observe( document.body, {
		childList: true,
		subtree: true
	} );

	// Look for the specific element in legacy non-block based themes
	var $addedToCartElement = $( 'dd.variation-AddedToCart' );

	if ( $addedToCartElement.length ) {
		$addedToCartElement.each( function( index, element ) {
			// Find the text element for this specific element
			var $textElement = $( element ).find( 'p' );

			if ( $textElement.length ) {
				// Start the live timer for this element
				startLiveTimer( $textElement );
			}
		} );
	}

	// Find the target block within the newly added nodes
	var $addedToCartBlock = $( '.wc-block-components-product-details__added-to-cart' );

	if ( $addedToCartBlock.length ) {
		$addedToCartBlock.each( function( index, block ) {
			// Find the text element for this specific block
			var $textElement = $( block ).find( '.wc-block-components-product-details__value' );

			if ( $textElement.length ) {
				// Start the live timer for this element
				startLiveTimer( $textElement );
			}
		} );
	}

	// Function to parse the time string and start the timer
	function startLiveTimer( $element ) {
		// Get the initial text (e.g., "2 days 1 hour 22 minutes 41 seconds ago")
		var initialText = $element.text().trim();
		
		// 1. Parse the string to extract days, hours, minutes, seconds
		var days = 0, hours = 0, minutes = 0, seconds = 0;
		
		// Match patterns for each time unit
		var dayMatch    = initialText.match( /(\d+)\s*day/ );
		var hourMatch   = initialText.match( /(\d+)\s*hour/ );
		var minuteMatch = initialText.match( /(\d+)\s*minute/ );
		var secondMatch = initialText.match( /(\d+)\s*second/ );
		
		if ( dayMatch ) days       = parseInt( dayMatch[1], 10 );
		if ( hourMatch ) hours     = parseInt( hourMatch[1], 10 );
		if ( minuteMatch ) minutes = parseInt( minuteMatch[1], 10 );
		if ( secondMatch ) seconds = parseInt( secondMatch[1], 10 );
		
		// 2. Convert everything to total seconds
		var totalSeconds = ( days * 86400 ) + ( hours * 3600 ) + ( minutes * 60 ) + seconds;
		
		// 3. Set up an interval to update every second
		var timerInterval = setInterval( function() {
			totalSeconds++; // Increment the time by 1 second
			
			// 4. Convert total seconds back to days, hours, minutes, seconds
			var days = Math.floor( totalSeconds / 86400 );
			var remainingAfterDays = totalSeconds % 86400;
			
			var hrs = Math.floor( remainingAfterDays / 3600 );
			var remainingAfterHours = remainingAfterDays % 3600;
			
			var mins = Math.floor( remainingAfterHours / 60 );
			var secs = remainingAfterHours % 60;
			
			// 5. Format the new time string
			var timeParts = [];
			
			if ( days > 0 ) {
				timeParts.push( days + ' day' + ( days !== 1 ? 's' : '' ) );
			}

			if ( hrs > 0 ) {
				timeParts.push( hrs + ' hour' + ( hrs !== 1 ? 's' : '' ) );
			}

			if ( mins > 0 ) {
				timeParts.push( mins + ' minute' + ( mins !== 1 ? 's' : '' ) );
			}

			// Always show seconds, even if 0
			timeParts.push( secs + ' second' + ( secs !== 1 ? 's' : '' ) );
			
			var newTimeString = timeParts.join( ' ' ) + ' ago';
			
			// 6. Update the element's text
			$element.text( newTimeString );
			
		}, 1000 ); // Update every 1000 milliseconds (1 second)
	}
} );