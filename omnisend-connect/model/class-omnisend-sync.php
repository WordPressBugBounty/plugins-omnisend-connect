<?php
/**
 * Omnisend Sync Class
 *
 * @package OmnisendPlugin
 */

defined( 'ABSPATH' ) || exit;

class Omnisend_Sync {

	const FIELD_NAME     = 'omnisend_last_sync';
	const STATUS_ERROR   = 'error';
	const STATUS_SKIPPED = 'skipped';

	public static function mark_contact_as_synced( $user_id ) {
		update_user_meta( $user_id, self::FIELD_NAME, gmdate( DATE_ATOM, time() ) );
	}

	public static function mark_contact_as_error( $user_id ) {
		update_user_meta( $user_id, self::FIELD_NAME, self::STATUS_ERROR );
	}

	public static function was_category_synced_before( $category_id ) {
		$last_sync = self::get_category_sync_status( $category_id );
		return ! empty( $last_sync ) && $last_sync != self::STATUS_ERROR;
	}

	public static function get_category_sync_status( $category_id ) {
		return get_term_meta( $category_id, self::FIELD_NAME, true );
	}

	public static function mark_category_sync_as_synced( $category_id ) {
		update_term_meta( $category_id, self::FIELD_NAME, gmdate( DATE_ATOM ) );
	}

	public static function mark_category_sync_as_error( $category_id ) {
		update_term_meta( $category_id, self::FIELD_NAME, self::STATUS_ERROR );
	}

	public static function delete_category_meta_data( $category_id ) {
		delete_metadata( 'term', $category_id, self::FIELD_NAME, '', false );
	}
}
