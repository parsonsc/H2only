<?php
include_once 'ClientBase.php';
include_once 'Http/CurlWrapper.php';

class TeamApi extends ClientBase
{		
	public $Parent;
	public $curlWrapper;
	
	public function __construct($justGivingApi)
	{
		$this->Parent		=	$justGivingApi;
		$this->curlWrapper	= new CurlWrapper();
		$this->curlWrapper->setDefaults();        
	}

	public function Create($team)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/team/" + $team->teamShortName;
		$url = $this->BuildUrl($locationFormat);
		$payload = json_encode($team);
        
		$fh = fopen('php://temp', 'r+');
		fwrite($fh, $payload);
		rewind($fh);
			
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
		$this->curlWrapper->addOption(CURLOPT_INFILE, $fh);
		$this->curlWrapper->addOption(CURLOPT_INFILESIZE, strlen($payload)); 
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);

		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));            
		$json = $this->curlWrapper->put($url);		      
		return json_decode($json);
	}
    
    public function Exists($team)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/team/" + $rteam->teamShortName;
		$url = $this->BuildUrl($locationFormat);
        			
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);

		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '. $this->BuildAuthenticationValue() ));            
		$this->curlWrapper->head($url);	
        if($this->curlWrapper->getTransferInfo('http_code') == 200)
		{
			return true;
		}
		else 
		{
			return false;
		}        
	}        
    
	public function Join($teamShortName, $user, $page)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/team/join/" + $teamShortName;
		$url = $this->BuildUrl($locationFormat);
        
        // one item only in team which is 
		$payload = json_encode($team);
        
		$fh = fopen('php://temp', 'r+');
		fwrite($fh, $payload);
		rewind($fh);
			
		$this->curlWrapper->addOption(CURLOPT_INFILE, $fh);
		$this->curlWrapper->addOption(CURLOPT_INFILESIZE, strlen($payload)); 
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);

		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $user , 
		    'Authorization' => 'Basic '.$user ));            
		$this->curlWrapper->put($url);	
        if($this->curlWrapper->getTransferInfo('http_code') == 200)
		{
			return true;
		}
		else 
		{
			return false;
		}        
	}    
}