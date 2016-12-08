<?php
/**
 * The template for displaying loop button book.
 *
 * Override this template by copying it to your theme
 *
 * @author  AweTeam
 * @package AweBooking/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$button_style = get_theme_mod('button_style', 'style-1');

printf(
	'<a href="#" data-id="%d" class="apb-btn btn-primary %s %s" title="%s">%s</a>',
	absint( get_the_ID() ),
    $button_style,
	'apb-book-now-js',
	esc_attr( get_the_title() ),
	esc_html__( 'BOOK ROOM', 'awebooking' )
);
