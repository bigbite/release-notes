<?php

declare( strict_types = 1 );

use Big_Bite\Release_Notes\Widget;
use PHPUnit\Framework\TestCase;

/**
 * Test for the Widget class.
 */
class Widget_Test extends TestCase {

	public function testRenderWidget(): void {
		$widget = new Widget();

		$this->expectOutputRegex( '/\s*<article class="release-note-widget">.*<h1 class="release-note-title">post-title<\/h1>.*<\/article>\s*/s' );
		$widget->render_widget();
	}

}
