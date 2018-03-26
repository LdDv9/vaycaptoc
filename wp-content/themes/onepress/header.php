<?php
/**
 * The header for the OnePress theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OnePress
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
    <script  src="/wp-includes/js/jquery/jquery.js?ver=1.12.4"></script>
    
    <!--<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>-->
    
    <?php wp_head(); ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116292382-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-116292382-1');
    </script>


</head>

<body <?php body_class(); ?>>
<?php do_action( 'onepress_before_site_start' ); ?>
<div id="page" class="hfeed site">
    <?php
    /**
     * @since 2.0.0
     */
    onepress_header();
    ?>
