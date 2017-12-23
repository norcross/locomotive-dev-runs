<?php
/**
 * Plugin Name: Locomotive Dev Runs
 * Plugin URI:  https://github.com/norcross/locomotive-dev-runs
 * Description: Some random batch processes I use a lot.
 * Version:     0.0.1
 * Author:      Andrew Norcross
 * Author URI:  http://andrewnorcross.com
 * Text Domain: locomotive-dev-runs
 * Domain Path: /languages
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 *
 * @package LocomotiveDevRuns
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Call our class.
 */
class LocomotiveDevRuns_Base {

	/**
	 * Call our hooks.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'locomotive_init',                                          array( $this, 'setup_batch_processes'       )           );
	}

	/**
	 * Create our various batch processes.
	 *
	 * @return void
	 */
	public function setup_batch_processes() {

		// Handle deleting our storify stories.
		register_batch_process( array(
			'name'      => 'Delete Storify Stories',
			'type'      => 'post',
			'args'      => array(
				'post_type'      => 'storify-stories',
				'post_status'    => 'any',
			),
			'callback'  => array( $this, 'delete_storify_stories' ),
		));

		// Delete all the individual elements.
		register_batch_process( array(
			'name'      => 'Delete Storify Elements',
			'type'      => 'comment',
			'args'      => array(
				'type'       => 'storify-element',
				'status'     => 'approve',
			),
			'callback'  => array( $this, 'delete_storify_elements' ),
		));
	}

	/**
	 * Delete all the existing Storify stories.
	 *
	 * @param  object $story  The WP_Post object for the story.
	 *
	 * @return void
	 */
	public function delete_storify_stories( $story ) {
		wp_delete_post( $story->ID, true );
	}

	/**
	 * Delete all the existing Storify story elements.
	 *
	 * @param  object $element  The WP_Comment object for the element.
	 *
	 * @return void
	 */
	public function delete_storify_elements( $element ) {
		wp_delete_comment( $element->comment_ID, true );
	}


	// End our class.
}

// Call our class.
$LocomotiveDevRuns_Base = new LocomotiveDevRuns_Base();
$LocomotiveDevRuns_Base->init();
