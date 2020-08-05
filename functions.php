<?php

class wpc_post_editor {

	public function __construct(){

		add_action('add_meta_boxes', [$this, 'create_meta_box']);
		add_action('save_post', [$this, 'save_editor']);

	}

	public function create_meta_box(){

		add_meta_box('wpc_editor', 'Post Editor', [$this, 'meta_box_html'], ['post']);

	}

	public function save_editor( $post_id ) {

		if(isset($_POST['wpc_post_editor']) && is_numeric($_POST['wpc_post_editor']) ){

			$editor_id = sanitize_text_field($_POST['wpc_post_editor']);

			update_post_meta($post_id, 'wpc_post_editor', $editor_id );

		}

	}

	public function meta_box_html(){

		$user_query = new WP_User_Query([
			'role' => 'editor',
			'number' => '-1',
			'fields' => [
				'display_name',
				'ID',
			],
		]);

		$editors = $user_query->get_results();

		if( ! empty( $editors ) ) {

		?>

			<label for="post_editor">Editor:</label>
			<select name="wpc_post_editor" id="post_editor">
				<option> - Select One -</option>
				<?php
				
					foreach ($editors as $editor) {
						echo '<option value="'.$editor->ID.'" '.selected(get_post_meta(get_the_ID(), 'wpc_post_editor', true), $editor->ID, false).'>'.$editor->display_name.'</option>';
					}

				?>
			</select>

		<?php

		} else {
			echo '<p>No Editors Found.</p>';
		}

	}
  
