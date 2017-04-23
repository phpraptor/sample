<?php

namespace Raptor;

use Raptor\Request\Collections\QueryCollection;
use Raptor\Request\Collections\ParamsCollection;
use Raptor\Request\Collections\FilesCollection;
use Raptor\Request\Collections\CookiesCollection;
use Raptor\Request\Collections\HeadersCollection;
use Raptor\Request\Collections\SessionCollection;
use Raptor\Request\Components\Origin;
use Raptor\Request\Components\URI;

class Request
{
    /**
     * Query string parameters ($_GET).
     *
     * @var \Raptor\Request\Collections\QueryCollection
     */
	public $query;

    /**
     * Request body parameters ($_POST).
     *
     * @var \Raptor\Request\Collections\ParamsCollection
     */
	public $params;

    /**
     * Uploaded files ($_FILES).
     *
     * @var \Raptor\Request\Collections\FilesCollection
     */
    public $files;

    /**
     * Cookies ($_COOKIE).
     *
     * @var \Raptor\Request\Collections\CookiesCollection
     */
    public $cookies;

    /**
     * Headers (taken from the $_SERVER).
     *
     * @var \Raptor\Request\Collections\HeadersCollection
     */
    public $headers;

    /**
     * Session (taken from the $_SESSION).
     *
     * @var \Raptor\Request\Collections\SessionCollection
     */
    public $session;

    /**
     * @var \Raptor\Request\Support\Origin
     */
    public $origin;

    /**
     * @var string
     */
    protected $method;

    /**
     * Constructor.
     */
	function __construct()
	{
		$this->init();
	}

    /**
     * Initialize the request.
     */
    public function init()
    {
        $this->query = new QueryCollection();
        $this->params = new ParamsCollection();
        $this->files = new FilesCollection();
        $this->cookies = new CookiesCollection();
        $this->headers = new HeadersCollection();
        $this->session = new SessionCollection();
        $this->origin = new Origin();
        $this->uri = new URI();
    }

	/**
	 * Get request method.
	 *
	 * @return  string
	 */
	public function method()
	{
		if ($this->method) return $this->method;
		if (PHP_SAPI === 'cli') return $this->method = 'CLI';
		$this->method = $_SERVER['REQUEST_METHOD'];
		if ($this->method === 'POST') {
			if (!empty($_SERVER['X-HTTP-METHOD-OVERRIDE'])) {
				$this->method = strtoupper($_SERVER['X-HTTP-METHOD-OVERRIDE']);
			} elseif (!empty($_POST['_method'])) {
				$this->method = strtoupper($_POST['_method']);
			}
		}
		return $this->method;
	}

	/**
	 * Get request URI scheme.
	 *
	 * @return  boolean
	 */
	public function scheme()
	{
		return $this->uri->scheme();
	}

	/**
	 * Get request path.
	 *
	 * @return  string
	 */
	public function path()
	{
		return $this->uri->path();
	}

    /**
     * Returns true if the request is a XMLHttpRequest.
     *
     * It works if your JavaScript library sets an X-Requested-With HTTP header.
     * It is known to work with common JavaScript frameworks:
     *
     * @see http://en.wikipedia.org/wiki/List_of_Ajax_frameworks#JavaScript
     *
     * @return bool true if the request is an XMLHttpRequest, false otherwise
     */
    public function ajax()
    {
        return 'XMLHttpRequest' == $_SERVER['X-Requested-With'];
    }

    /**
     * Returns true if the request is through CLI.
     *
     * @return bool
     */
    public function cli()
    {
    	return PHP_SAPI === 'cli';
    }
}