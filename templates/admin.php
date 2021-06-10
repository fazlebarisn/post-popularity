<div class="wrap">
	<h1>Post Popularity Plugin</h1>

	<?php settings_errors() ?>

	 <ul class="nav nav-tabs">
	 	<li class="active"><a href="#tab-1">Manage Settings</a></li>
	 	<li><a href="#tab-2">Updates</a></li>
	 	<li><a href="#tab-3">About</a></li>
	 </ul>

	 <div class="tab-content">
	 	<div id="tab-1" class="tab-pane active">
			<form action="options.php" method="post" accept-charset="utf-8">
				<?php
					settings_fields( 'like_dislike_options_group' ); // option group id
					do_settings_sections( 'like_dislike_menu' ); // page slug of section
					submit_button();
				?>
			</form>	
	 	</div>

	 	<div id="tab-2" class="tab-pane">
	 		<h3>Updates</h3>
	 	</div>

	 	<div id="tab-3" class="tab-pane">
	 		<h3>About us</h3>
	 	</div>

	 </div>
</div>