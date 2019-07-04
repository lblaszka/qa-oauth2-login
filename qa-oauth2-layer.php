<?php

class qa_html_theme_layer extends qa_html_theme_base
{
	public function head_css()
	{
		
		qa_html_theme_base::head_css();
		
		$this->output(
			'<style>',
			'.qa-nav-user-oauth2-login {padding:0px;}',
			'</style>'
		);
	}
}
