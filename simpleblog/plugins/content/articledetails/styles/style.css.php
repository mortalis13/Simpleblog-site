<?php 
/**
* @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// No direct access to this file
defined('_JEXEC') or die;

// Explicitly declare the type of content
header("Content-type: text/css; charset=UTF-8");
?>

.articledetails {
	overflow: hidden;
}

	.articledetails .head {
		float: left;
	   	margin: 0 8px 0 0;
		max-width: <?php echo $head_width; ?>px;
		height: <?php echo $head_height; ?>px;	
		width: <?php echo $head_width; ?>px;		
	}
	
		.articledetails .head .calendar {
			font-size: <?php echo $font_ref_cal; ?>px;		
		}
				
			.articledetails .head .calendar .position1, 
			.articledetails .head .calendar .position2, 
			.articledetails .head .calendar .position3, 
			.articledetails .head .calendar .position4, 
			.articledetails .head .calendar .position5 {
				display: block;
			}	
			
	.articledetails .info {
		overflow: hidden;
	}
	
		.articledetails .info .article_title {
		    display: inline;
			margin: 0;
		    padding: 0;
		}
		
		.articledetails .info p {
			margin: 0 !important;
		    padding: 0 !important;
		}
		
		.articledetails .info p + p {
			text-indent: 0 !important;
		}
	
		.articledetails .info .details {
			font-size: <?php echo ($font_details / 100); ?>em;
		}
		
			.articledetails .info .details [class^="SYWicon-"], 
			.articledetails .info .details [class*=" SYWicon-"] {
				font-size: 1em;
			    color: <?php echo $iconfont_color; ?>;
			    padding-right: 3px;
			}
			
			<?php if ($ie == 7) : ?>
		
				.articledetails .info .details [class^="SYWicon-"], 
				.articledetails .info .details [class*=" SYWicon-"] {
				    background-image: url("images/glyphicons-halflings.png");
				    background-position: 14px 14px;
				    background-repeat: no-repeat;
				    display: inline-block;
				    height: 14px;
				    line-height: 14px;
				    margin-top: 1px;
				    vertical-align: text-top;
				    width: 14px;
				}
				
				.articledetails .info .details .SYWicon-calendar {
				    background-position: -192px -120px;
				}
				
				.articledetails .info .details .SYWicon-user {
				    background-position: -168px 0;
				}
				
				.articledetails .info .details .SYWicon-eye {
				    background-position: -96px -120px;
				}
				
				.articledetails .info .details .SYWicon-star {
					background-position: -120px 0;
				}
				
				.articledetails .info .details .SYWicon-tag {
					background-position: -25px -48px;
				}
				
				.articledetails .info .details .SYWicon-folder {
					background-position: -384px -120px;
		    		width: 16px;
				}
				
				.articledetails .info .details .SYWicon-folder-open {
					background-position: -408px -120px;
		    		width: 16px;
				}
				
				.articledetails .info .details .SYWicon-clock {
				    background-position: -48px -24px;
				}
						
			<?php endif; ?>	
		
			.articledetails .info .details .delimiter { }
			
/* standard Joomla! templates overrides */
/* may not work on templates that override the standard views */

<?php if ($head_width > 0) : ?>
	/* move the votes so all info is aligned */
	.content_rating,
	.content_vote {
		margin-left: <?php echo ($head_width + 8); ?>px;
	}
<?php endif; ?>		

/* the following has been replaced with parameters in the plugin */

/* .item-page h2 (for instance) would also hide h2 tags present in the content. */
/* Although it is unlikely, it is safer to remove only the first occurence of the tag */
   
/*
.item-page h2:first-of-type,
.items-leading h2:first-of-type,
.items-row h2:first-of-type {
	display: none;
}
*/

<?php if ($ie > 0 && $ie < 9) : ?>
	/*
	.item-page h2,
	.items-leading h2,
	.items-row h2 {
		display: none;
	}
	*/
<?php endif; ?>

/* hide standard article details */
/*
.article-info {
  	display: none;
}
*/

/* remove tags (Joomla! 3.1+ only) */
/*
.item-page .tags {
  	display: none;
}
*/
