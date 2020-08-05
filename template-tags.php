<?php if ($author_id = get_post_meta(get_the_ID(), 'wpc_post_editor', true)) { ?>
      Editor: <?php echo get_the_author_meta('display_name', $author_id); ?>
<?php } ?>
