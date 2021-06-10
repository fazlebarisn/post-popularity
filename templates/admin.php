<div class="wrap">
	<h1>Post Popularity Plugin</h1>

	<?php settings_errors() ?>

    <form action="options.php" method="post" accept-charset="utf-8">
        <?php
            settings_fields( 'like_dislike_options_group' ); // option group id
            do_settings_sections( 'like_dislike_menu' ); // page slug of section
            submit_button();
        ?>
    </form>	

</div>