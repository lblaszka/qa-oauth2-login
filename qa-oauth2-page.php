<?php

class qa_oauth2_page
{
	private $directory;
	private $urltoroot;


	public function load_module($directory, $urltoroot)
	{
		$this->directory = $directory;
		$this->urltoroot = $urltoroot;
	}


	public function suggest_requests() // for display in admin interface
	{
        echo("suggest_requests");
		return array(
			array(
				'title' => 'Example',
				'request' => 'example-plugin-page',
				'nav' => 'M', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
			),
		);
	}


	public function match_request($request)
	{
		return $request == 'oauth2-login-page';
	}


	public function process_request($request)
	{
        $qa_content = qa_content_prepare();
        
        $prop = array (
            'name' => 'User_1'
        );

        $state='test';

        $protocol = 'https://';
        if( $_SERVER['SERVER_PORT'] == "80" )
            $protocol = 'http://';

        $callback = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        
        if( isset( $_GET['code']))
        {
            $token = $this->getToken( $_GET['code'], $callback, $state );
            
            if( $token != null )
            {
                $response = $this->getProfile( $token );
                if( $response == null )
                {
                    echo("Get profile ełor");
                }
                else
                {
                    $profileData = (array)json_decode( $response );

                    qa_log_in_external_user( "oauth2", $profileData["id"], array(
                        'confirmed' => true,
                        'email' => $profileData["email"],
                        'avatar' => qa_retrieve_url($profileData["avatar_url"]),
                        'handle' => $profileData["name"],
                        'name' => $profileData["login"]
                    ));
                    qa_redirect_raw("?");
                }
            }
            else
                qa_redirect_raw("?");

        }
        else
        qa_redirect_raw ( qa_html(qa_opt('qa_ouath2_login_auth_url')).'?response_type=code&client_id='.qa_html(qa_opt('qa_ouath2_login_client_id')).'&redirect_uri='.urlencode($callback).'&state='.$state );

    }
    

    public function getToken($code, $redirectUrl, $state)
    {

        $url = qa_opt('qa_ouath2_login_token_url');
        $data = array( 
            'client_id' => qa_html(qa_opt('qa_ouath2_login_client_id')),
            'client_secret' => qa_html(qa_opt('qa_ouath2_login_client_secret')),
            'code' => $code,
            'redirect_uri' => $redirectUrl,
            'state' => $state
        );

        $ch = curl_init($url);
        $postString = json_encode($data);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        
        parse_str( $result, $parseResponse );

        if( !isset( $parseResponse["access_token"] ) )
            return null;

        return $parseResponse["access_token"];
    }

    public function getProfile( $accessToken )
    {
        $url = qa_opt('qa_ouath2_login_profile_url');
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:token '.$accessToken,'User-Agent:'.$_SERVER['HTTP_USER_AGENT']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;


    }
}
