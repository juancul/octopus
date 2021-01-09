<?php

function tot_add_embed() {
	$tot_keys = tot_get_public_key();
	if(!is_wp_error( $tot_keys )) {
		?>
			<script id="tot-embed-code">
			(function(d){var b=window,a=document;b.tot=b.tot||function(){(b.tot.q=b.tot.q||[]).push(
		    arguments)};var c=a.getElementsByTagName("script")[0];a.getElementById("tot-embed")||(a=a.
		    createElement("script"),a.id="tot-embed",a.async=1,a.src=d,c.parentNode.insertBefore(a,c))
		    })("<?php echo tot_origin(); ?>/embed/embed.js");

		    tot('setPublicKey', '<?php echo $tot_keys; ?>');
		    </script>
		<?php
	}
}