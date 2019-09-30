<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WPOpal  Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
/**
 * Enable/distable share box
 */

global $post;
$args = array( 'position' => 'top', 'animation' => 'true' );
?>
<div class="opal-row">
	<div class="col-lg-12 col-md-12">
		<h6 class="pull-left"><?php esc_html_e("Share this:", "fullhouse"); ?></h6>
 		<div class="job-social-share">
				<div class="job-social-icons job-sicolor social-radius-rounded">
				<?php if((bool)opaljob_options('facebook_share_blog',true)): ?>
		 
					<a class="job-social-facebook" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Facebook" href="http://www.facebook.com/sharer.php?s=100&p&#91;url&#93;=<?php the_permalink(); ?>&p&#91;title&#93;=<?php the_title(); ?>" target="_blank" title="<?php esc_html_e('Share on facebook', 'opalestate-pro'); ?>">
						<i class="fa fa-facebook"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('twitter_share_blog',true)): ?>
		 
					<a class="job-social-twitter"  data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Twitter" href="http://twitter.com/home?status=<?php the_title(); ?> <?php the_permalink(); ?>" target="_blank" title="<?php esc_html_e('Share on Twitter', 'opalestate-pro'); ?>">
						<i class="fa fa-twitter"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('linkedin_share_blog',true)): ?>
		 
					<a class="job-social-linkedin"  data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="LinkedIn" href="http://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="<?php esc_html_e('Share on LinkedIn', 'opalestate-pro'); ?>">
						<i class="fa fa-linkedin"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('tumblr_share_blog',true)): ?>
		 
					<a class="job-social-tumblr" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Tumblr" href="http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink()); ?>&amp;name=<?php echo urlencode($post->post_title); ?>&amp;description=<?php echo urlencode(get_the_excerpt()); ?>" target="_blank" title="<?php esc_html_e('Share on Tumblr', 'opalestate-pro'); ?>">
						<i class="fa fa-tumblr"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('google_share_blog',true)): ?>
		 
					<a class="job-social-google" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Google plus" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,
			'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" target="_blank" title="<?php esc_html_e('Share on Google plus', 'opalestate-pro'); ?>">
						<i class="fa fa-google-plus"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('pinterest_share_blog',true)): ?>
		 
					<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>
					<a class="job-social-pinterest" data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode($full_image[0]); ?>" target="_blank" title="<?php esc_html_e('Share on Pinterest', 'opalestate-pro'); ?>">
						<i class="fa fa-pinterest"></i>
					</a>
		 
				<?php endif; ?>
				<?php if((bool)opaljob_options('mail_share_blog',true)): ?>
		 
					<a class="job-social-envelope"  data-toggle="tooltip" data-placement="<?php echo esc_attr($args['position']); ?>" data-animation="<?php echo esc_attr($args['animation']); ?>"  data-original-title="Email" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php the_permalink(); ?>" title="<?php esc_html_e('Email to a Friend', 'opalestate-pro'); ?>">
						<i class="fa fa-envelope"></i>
					</a>
		 
				<?php endif; ?>
			</div>
		</div>	
			
	</div>
</div>
