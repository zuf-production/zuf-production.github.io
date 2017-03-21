<?php
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage Digitec
 */




echo '<div id="comments">';

if ( post_password_required() ) {
	do_action( 'maven_comments_password' );
	echo '</div>';
	
	/* Stop the rest of comments.php from being processed,
	 * but don't kill the script entirely -- we still have
	 * to fully load the template.
	 */
	return;
}

// If there are comments
if ( have_comments() ) {
	do_action( 'maven_comments_loop' );

/* If there are no comments and comments are closed, let's leave a little note, shall we?
 * But we don't want the note on pages or post types that do not support comments.
 */
} elseif ( ! comments_open() && ! is_page() && post_type_supports(get_post_type(), 'comments') ) {

	echo '<hr />';
	echo '<p class="nocomments">'.__( 'Comments are closed.', 'digitec' ).'</p>';
}

/**
 * Setup the comment form
 *
 * @since 1.0
 */
$author = '<div class="control-group comment-form-author"><div class="controls"><input id="author" name="author" type="text" placeholder="'.__( 'Your name', 'digitec' ).'*" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" /></div></div>';

$email = '<div class="control-group comment-form-email"><div class="controls"><input id="email" name="email" type="text" placeholder="'.__( 'Your email', 'digitec' ).'*" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></div></div>';

$url = '<div class="control-group comment-form-url"><div class="controls"><input id="url" name="url" type="text" placeholder="'.__( 'Your website', 'digitec' ).'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div></div>';

// Set the fields
$fields =  array(
	'author' => $author,
	'email' => $email,
	'url' => $url
);

$comment_field = '<div class="control-group comment-form-comment"><div class="controls"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="'.__( 'Your message', 'digitec' ).'" aria-required="true"></textarea></div></div>';
	
// Set the arguments
$args = array (
	'fields' => $fields,
	'comment_field' => $comment_field,
	'class_submit' => 'digibutton',
	'label_submit' => __( 'Submit', 'digitec' ),
	'title_reply' => __( 'Leave a Comment', 'digitec' ),
	'comment_notes_before' => '<p class="comment-notes">'.__( 'Your email address will not be published. Required fields are marked *', 'digitec' ).'</p>',
	'comment_notes_after' => '',
	'cancel_reply_link' => __( 'Cancel', 'digitec' )
);

// Filter the args
$args = apply_filters( 'maven_comment_form_args', $args );

// Display the comment form
maven_comment_form( $args, get_the_ID() );

echo '</div>';
