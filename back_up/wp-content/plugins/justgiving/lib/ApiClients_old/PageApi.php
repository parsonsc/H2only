<?php

include_once 'ClientBase.php';
include_once 'Http/CurlWrapper.php';
include_once 'Model/RegisterPageRequest.php';
include_once 'Model/StoryUpdateRequest.php';

class PageApi extends ClientBase
{		
	public $Parent;
	public $curlWrapper;
	
	public function __construct($justGivingApi)
	{
		$this->Parent		=	$justGivingApi;
		$this->curlWrapper	= new CurlWrapper();
		$this->curlWrapper->setDefaults();        
	}
	
	public function Create($user, $pageCreationRequest)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages";
		$url = $this->BuildUrl($locationFormat);
		$payload = json_encode($pageCreationRequest);
        
		$fh = fopen('php://temp', 'r+');
		fwrite($fh, $payload);
		rewind($fh);
                
		$this->curlWrapper->resetAll();
		$this->curlWrapper->setDefaults();
        
		if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addOption(CURLOPT_PUT, true);
		$this->curlWrapper->addOption(CURLOPT_INFILE, $fh);
		$this->curlWrapper->addOption(CURLOPT_INFILESIZE, strlen($payload));
		$this->curlWrapper->addHeader(
			array(
                'Content-type' => 'application/json', 
                'Authorize' => 'Basic '. $user, 
                'Authorization' => 'Basic '.$user ));
		$json = $this->curlWrapper->put($url);
		//print_R($json);
		if($this->curlWrapper->getTransferInfo('http_code') == 201)
		{
			return json_decode($json); 
		}
		else if($this->curlWrapper->getTransferInfo('http_code') == 409){
			return false;
		}
		else
		{
            //print_r($this->curlWrapper);
			return false;
		}		
	}
	
	public function IsShortNameRegistered($pageShortName)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/" . $pageShortName;
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->resetAll();
        $this->curlWrapper->setDefaults();   
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);        
        $this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        $this->curlWrapper->addHeader(array(
            'Content-type' => 'application/json', 
            'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
            'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
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

	public function ListAll()
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages";
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
		$json = $this->curlWrapper->get($url);        
		return json_decode($json);
	}
	
	public function Retrieve($pageShortName)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/" . $pageShortName;
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
		$json = $this->curlWrapper->get($url);        
		return json_decode($json);
	}	
	
	public function SuggestPageShortNames($preferredName)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/suggest?preferredName=" . urlencode ($preferredName);
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
		$json = $this->curlWrapper->get($url);	
		return json_decode($json);
	}	
	
	public function RetrieveDonationsForPage($pageShortName, $pageSize=50, $pageNumber=1)
	{
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/".$pageShortName."/donations"."?PageSize=".$pageSize."&PageNum=".$pageNumber;
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));
		$json = $this->curlWrapper->get($url);        
		return json_decode($json);
	}
	
	public function UpdateStory($pageShortName, $storyUpdate)
	{		
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/" . $pageShortName;
		$url = $this->BuildUrl($locationFormat);
		$storyUpdateRequest = new StoryUpdateRequest();
		$storyUpdateRequest->storySupplement = $storyUpdate;
		$payload = json_encode($storyUpdateRequest);
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addOption(CURLOPT_POSTFIELDS, $payload);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => 'application/json', 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
		$json = $this->curlWrapper->post($url);	
		
		if($this->curlWrapper->getTransferInfo('http_code') == 200)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function UploadImage($pageShortName, $caption, $filename, $imageContentType)
	{            
		$fh = fopen($filename, 'r');
		$imageBytes = fread($fh, filesize($filename));
		fclose($fh);
	
		$locationFormat = $this->Parent->RootDomain . "{apiKey}/v{apiVersion}/fundraising/pages/" . $pageShortName . "/images?caption=" . urlencode ($caption);
		$url = $this->BuildUrl($locationFormat);
		$this->curlWrapper->addOption(CURLOPT_POSTFIELDS, $imageBytes); 
		$this->curlWrapper->addOption(CURLOPT_USERPWD, $this->Parent->Username.":".$this->Parent->Password);
        if ($this->Parent->Debug) $this->curlWrapper->addOption(CURLOPT_VERBOSE, 1);
		$this->curlWrapper->addOption(CURLOPT_POSTFIELDS, $payload);
		$this->curlWrapper->addHeader(array(
		    'Content-type' => $imageContentType, 
		    'Authorize' => 'Basic '. $this->BuildAuthenticationValue() , 
		    'Authorization' => 'Basic '.$this->BuildAuthenticationValue() ));        
		$json = $this->curlWrapper->post($url);			
		if($this->curlWrapper->getTransferInfo('http_code') == 200)
		{
			return true;
		}
		else
		{
			return $this->curlWrapper->getTransferInfo();
		}
	}
}