<div class="wrap buzz-form">
  <div id="buzz-addid-form-container"> 
	<div id="buzz-addid-box">
		<label for="buzz-url"><b>Podcast ID to Pull</b></label>
	    <div class="field buzz-field-container">
        <?php settings_errors(); ?>
        <form method="post" action="options.php">
            <?php settings_fields( 'podcast_info' ); ?>
            <?php  $podcastid = esc_attr(get_option('podcastid'));
              echo '<input type="text" name="podcastid" value="'.$podcastid.'" placeholder="Podcast ID" /> '; ?>
            <?php do_settings_sections( 'buzzsprout-sync' ); ?>
            <?php submit_button(); ?>
        </form>
      </div>
	</div>
  </div>
</div>