<?php

namespace Big_Bite\release_notes;

/**
 * Runs the plugin setup sequence.
 *
 * @return void
 */
function setup() : void {
	if(
		! defined( 'RELEASE_NOTES_EDITOR_JS' )
	) {
		throw new \Error( "Asset constants are not defined. You may need to run an asset build." );
	}

	new Loader();
	new RestEndpoints();
	new PostType();
	new Widget();
	new AdminBar();
	new Archive();
	new RegisterSettings();
	new ReleasePublish();
}
