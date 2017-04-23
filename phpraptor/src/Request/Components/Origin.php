<?php

namespace Raptor\Request\Components;

class Origin
{
	/**
     * @var string
     */
	protected $ip;
	
	/**
     * @var string
     */
	protected $client;

	/**
     * @var string
     */
	protected $os;

	/**
     * @var string
     */
	protected $locale;

	/**
     * @var string
     */
	protected $charset;

	/**
     * @var string
     */
	protected $accepts;

    /**
     * Get the clien't IP.
     *
     * @return string
     */
	public function ip()
	{
		if ($this->ip) return $this->ip;
		return $this->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
	}

    /**
     * Get the clien't client.
     *
     * @return string
     */
	public function client()
	{
		if ($this->client) return $this->client;
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') || strpos($_SERVER['HTTP_USER_AGENT'], 'OPR/')) return $this->client = 'opera';
		    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Edge')) return  $this->client ='edge';
		    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) return  $this->client ='chrome';
		    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) return  $this->client ='safari';
		    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) return  $this->client ='firefox';
		    elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') || strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7')) return  $this->client ='ie';
	    }
	    return  $this->client = 'null';
	}

    /**
     * Get the clien't os.
     *
     * @return string
     */
	public function os()
	{
		if ($this->os) return $this->os;
		return $this->os = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
	}

    /**
     * Get the clien't locale.
     *
     * @return string
     */
	public function locale()
	{
		if ($this->locale) return $this->locale;
		return $this->locale = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : null;
	}

    /**
     * Get the clien't charset.
     *
     * @return string
     */
	public function charset()
	{
		if ($this->charset) return $this->charset;
		return $this->charset = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : null;
	}

    /**
     * Get the clien't accepts.
     *
     * @return string
     */
	public function accepts()
	{
		if ($this->accepts) return $this->accepts;
		return $this->accepts = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : null;
	}
}