( function( api ) {

	// Extends our custom "pastry-shop" section.
	api.sectionConstructor['pastry-shop'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );