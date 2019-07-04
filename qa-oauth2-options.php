<?php

class qa_oauth2_options
{
	public function admin_form()
	{
		$saved = false;

		if (qa_clicked('qa_ouath2_login_save_button')) {
			qa_opt('qa_ouath2_login_label', qa_post_text('qa_ouath2_login_label'));
			qa_opt('qa_ouath2_login_auth_url', qa_post_text('qa_ouath2_login_auth_url'));
			qa_opt('qa_ouath2_login_token_url', qa_post_text('qa_ouath2_login_token_url'));
			qa_opt('qa_ouath2_login_profile_url', qa_post_text('qa_ouath2_login_profile_url'));
			qa_opt('qa_ouath2_login_client_id', qa_post_text('qa_ouath2_login_client_id'));
			qa_opt('qa_ouath2_login_client_secret', qa_post_text('qa_ouath2_login_client_secret'));
			$saved = true;
		}

		return array(
			'ok' => $saved ? 'Saved' : null,

			'fields' => array(

				array(
					'label' => 'Label:',
					'value' => qa_html(qa_opt('qa_ouath2_login_label')),
					'tags' => 'name="qa_ouath2_login_label"',
                ),
                
				array(
					'label' => 'Authorize url:',
					'value' => qa_html(qa_opt('qa_ouath2_login_auth_url')),
					'tags' => 'name="qa_ouath2_login_auth_url"',
				),

				array(
					'label' => 'Token url:',
					'value' => qa_html(qa_opt('qa_ouath2_login_token_url')),
					'tags' => 'name="qa_ouath2_login_token_url"',
				),

				array(
					'label' => 'Profile url:',
					'value' => qa_html(qa_opt('qa_ouath2_login_profile_url')),
					'tags' => 'name="qa_ouath2_login_profile_url"',
				),

				array(
					'label' => 'Client id:',
					'value' => qa_html(qa_opt('qa_ouath2_login_client_id')),
					'tags' => 'name="qa_ouath2_login_client_id"',
				),

				array(
					'label' => 'Client secret:',
					'value' => qa_html(qa_opt('qa_ouath2_login_client_secret')),
                    'tags' => 'name="qa_ouath2_login_client_secret"',
                    'type' => 'password'
				),
			),

			'buttons' => array(
				array(
					'label' => 'Save Changes',
					'tags' => 'name="qa_ouath2_login_save_button"',
				),
			),
		);
	}
}
