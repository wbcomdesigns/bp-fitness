<?php
defined( 'ABSPATH' ) || exit; // Exit if accessed directly
global $bpfitness;
?>
<!-- Record points playing the video -->
<div class="bpfit-play-video-gain-points">
	<h3><?php _e( 'Play this video to gain points', BPFIT_TEXT_DOMAIN );?></h3>
	<?php
	if( !empty( $bpfitness->video_url ) ) {
		$video_url = $bpfitness->video_url;
		$video_type = $bpfitness->video_type;

		if( $video_type == 'other' ) {
			?>
			<video width="320" height="240" controls>
				<source src="<?php echo $video_url;?>" type="video/mp4">
			</video>
			<?php
		} else {
			echo '<div class="bpfit-video-embed">';
			echo wp_oembed_get( $video_url );
			echo '</div>';
		}
		}?>
</div>