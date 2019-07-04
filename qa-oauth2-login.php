<?php

class qa_oauth2_login
{
	public function login_html($tourl, $context)
	{
		if( $this->isReady() )
		{
			$this->putOauth2LoginButton();
		}
	}

	private function isReady()
	{
		if( qa_opt('qa_ouath2_login_label') == null )
			return false;
		if( qa_opt('qa_ouath2_login_auth_url') == null )
			return false;
		if( qa_opt('qa_ouath2_login_token_url') == null )
			return false;
		if( qa_opt('qa_ouath2_login_profile_url') == null )
			return false;
		if( qa_opt('qa_ouath2_login_client_id') == null )
			return false;
		if( qa_opt('qa_ouath2_login_client_secret') == null )
			return false;
		return true;
	}

	private function putOauth2LoginButton()
	{
		?>
		<a href="index.php/?qa=oauth2-login-page" >
			<input type="submit" class="qa-form-tall-button qa-form-tall-button-login" value="<?php echo(qa_opt('qa_ouath2_login_label'))?>" >
		</a>
		<?php
	}
}


