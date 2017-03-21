<?php
/**
 * The template for displaying the header structure
 *
 * @package WordPress
 * @subpackage Digitec
 */




do_action( 'maven_doctype' );
do_action( 'maven_title' );
do_action( 'maven_meta' );
do_action( 'maven_favicon' );
wp_head();
?>

</head>
<body <?php body_class(); ?>>

<?php do_action( 'maven_before' ); ?>

<div id="wrapper" class="clearfix">

<?php
do_action( 'maven_before_header' );
do_action( 'maven_header' );
do_action( 'maven_after_header' );