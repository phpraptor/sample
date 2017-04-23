<?php

namespace Raptor\Request\Components;

class URI
{
	/**
     * @var string
     */
	protected $scheme;

	/**
     * @var string
     */
	protected $host;

	/**
     * @var string
     */
	protected $prefix;

	/**
     * @var string
     */
	protected $port;

	/**
     * @var string
     */
	protected $root;
	
	/**
     * @var string
     */
	protected $path;

	/**
     * @var array
     */
	protected $segments;

    /**
     * Gets the URI scheme.
     *
     * @return string
     */
    public function scheme()
    {
    	if ($this->scheme) return $this->scheme;
        return $this->scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
    }

    /**
     * Returns the HTTP host being requested.
     *
     * This method can read the client host name from the "X-Forwarded-Host" header
     * when trusted proxies were set via "setTrustedProxies()".
     *
     * The "X-Forwarded-Host" header must contain the client host name.
     *
     * If your reverse proxy uses a different header name than "X-Forwarded-Host",
     * configure it via "setTrustedHeaderName()" with the "client-host" key.
     *
     * @param  boolean $port If true the port name will be appended to the host if it's non-standard.
     * @return string
     *
     * @throws \UnexpectedValueException when the host name is invalid
     */
    public function host($port = false)
    {
    	if (!$this->host) {
	        if (!$this->host = $_SERVER['HTTP_HOST']) {
	            if (!$this->host = $_SERVER['SERVER_NAME']) {
	                $this->host = $_SERVER['SERVER_ADDR'];
	            }
	        }

	        // trim and remove port number from host
	        // host is lowercase as per RFC 952/2181
	        $this->host = strtolower(preg_replace('/:\d+$/', '', trim($this->host)));

	        // as the host can come from the user (HTTP_HOST and depending on the configuration, SERVER_NAME too can come from the user)
	        // check that it does not contain forbidden characters (see RFC 952 and RFC 2181)
	        // use preg_replace() instead of preg_match() to prevent DoS attacks with long host names
	        if ($this->host && '' !== preg_replace('/(?:^\[)?[a-zA-Z0-9-:\]_]+\.?/', '', $this->host)) {
	            throw new \Exception(sprintf('Invalid Host "%s"', $this->host));
	        }
	    }

	    if (!$port) return $this->host;

        $scheme = $this->scheme();
        $port = $this->port();

        if (('http' == $scheme && $port == 80) || ('https' == $scheme && $port == 443)) {
            return $this->host;
        }

        return $this->host.':'.$port;
    }

    /**
     * Get the URI prefix.
     *
     * @return string
     */
	public function prefix()
	{
		if ($this->prefix) return $this->prefix;
		$filename = basename($_SERVER['SCRIPT_FILENAME']);

        if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
            $this->prefix = $_SERVER['SCRIPT_NAME'];
        } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
            $this->prefix = $_SERVER['PHP_SELF'];
        } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
            $this->prefix = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
        } else {
            // Backtrack up the script_filename to find the portion matching
            // php_self
            $segs = explode('/', trim($_SERVER['SCRIPT_FILENAME'], '/'));
            $segs = array_reverse($segs);
            $index = 0;
            $last = count($segs);
            $this->prefix = '';
            do {
                $seg = $segs[$index];
                $this->prefix = '/'.$seg.$this->prefix;
                ++$index;
            } while ($last > $index && (false !== $pos = strpos($_SERVER['PHP_SELF'], $this->prefix)) && 0 != $pos);
        }
        return $this->prefix = trim(str_replace($filename, '', $this->prefix), '/');
	}

    /**
     * Returns the port on which the request is made.
     *
     * This method can read the client port from the "X-Forwarded-Port" header
     * when trusted proxies were set via "setTrustedProxies()".
     *
     * The "X-Forwarded-Port" header must contain the client port.
     *
     * If your reverse proxy uses a different header name than "X-Forwarded-Port",
     * configure it via "setTrustedHeaderName()" with the "client-port" key.
     *
     * @return string
     */
    public function port()
    {
        if (!$host = $_SERVER['HTTP_HOST']) {
            return $_SERVER['SERVER_PORT'];
        }

        if ($host[0] === '[') {
            $pos = strpos($host, ':', strrpos($host, ']'));
        } else {
            $pos = strrpos($host, ':');
        }

        if (false !== $pos) {
            return (int) substr($host, $pos + 1);
        }

        return 'https' === $this->scheme() ? 443 : 80;
    }

    /**
     * Get the URI root.
     *
     * @return string
     */
	public function root()
	{
		if ($this->root) return $this->root;
        return $this->root = $this->scheme().'://'.$this->host(true).'/'.$this->prefix();
	}

    /**
     * Get the URI path.
     *
     * @return string
     */
	public function path()
	{
		if (PHP_SAPI === 'cli') {
			global $argv;
			return '/'.trim(implode('/', $argv), '/');
		}
		if ($this->path) return $this->path;
		$this->path = $this->prepareRequestUri();
		if ($this->prefix() !== '' && strpos(trim($this->path,'/'), $this->prefix()) === 0) {
			$this->path = substr($this->path, strlen($this->prefix) + 1);
		}
        return $this->path = str_replace('//', '', explode('?', $this->path)[0]);
	}

    /*
     * The following methods are derived from code of the Zend Framework (1.10dev - 2010-01-24)
     *
     * Code subject to the new BSD license (http://framework.zend.com/license/new-bsd).
     *
     * Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
     */

    protected function prepareRequestUri()
    {
        $requestUri = '';

        if (!empty($_SERVER['HTTP_X_ORIGINAL_URL'])) {
            // IIS with Microsoft Rewrite Module
            $requestUri = $_SERVER['HTTP_X_ORIGINAL_URL'];
            unset($_SERVER['HTTP_X_ORIGINAL_URL']);
            unset($_SERVER['UNENCODED_URL']);
            unset($_SERVER['IIS_WasUrlRewritten']);
        } elseif (!empty($_SERVER['HTTP_X_REWRITE_URL'])) {
            // IIS with ISAPI_Rewrite
            $requestUri = $_SERVER['HTTP_X_REWRITE_URL'];
            unset($_SERVER['HTTP_X_REWRITE_URL']);
        } elseif (!empty($_SERVER['IIS_WasUrlRewritten']) && $_SERVER['IIS_WasUrlRewritten'] == '1' && $_SERVER['UNENCODED_URL'] != '') {
            // IIS7 with URL Rewrite: make sure we get the unencoded URL (double slash problem)
            $requestUri = $_SERVER['UNENCODED_URL'];
            unset($_SERVER['UNENCODED_URL']);
            unset($_SERVER['IIS_WasUrlRewritten']);
        } elseif (!empty($_SERVER['REQUEST_URI'])) {
            $requestUri = $_SERVER['REQUEST_URI'];
            // HTTP proxy reqs setup request URI with scheme and host [and port] + the URL path, only use URL path
            $schemeAndHttpHost = $this->scheme().'://'.$this->host();
            if (strpos($requestUri, $schemeAndHttpHost) === 0) {
                $requestUri = substr($requestUri, strlen($schemeAndHttpHost));
            }
        } elseif (!empty($_SERVER['ORIG_PATH_INFO'])) {
            // IIS 5.0, PHP as CGI
            $requestUri = $_SERVER['ORIG_PATH_INFO'];
            if ('' != $_SERVER['QUERY_STRING']) {
                $requestUri .= '?'.$_SERVER['QUERY_STRING'];
            }
            unset($_SERVER['ORIG_PATH_INFO']);
        }

        // normalize the request URI to ease creating sub-requests from this request
        $_SERVER['REQUEST_URI'] = $requestUri;

        return $requestUri;
    }
}