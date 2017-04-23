<?php

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

if (! function_exists('html')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function html(string $template, array $data = [])
    {
        // var_dump($data, realpath(server()->paths()->get('resources').'/htmls/'.$template.'.php'));
        return new \Raptor\Server\Responses\Html($data, realpath(server()->paths()->get('resources').'/htmls/'.$template.'.php'));
    }
}

if (! function_exists('json')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function json(array $data = [])
    {
        return new \Raptor\Server\Responses\Json($data);
    }
}

if (! function_exists('request')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function request()
    {
        global $request;
        return $request;
    }
}

if (! function_exists('server')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function server()
    {
        global $server;
        return $server;
    }
}

if (! function_exists('method_field')) {
    /**
     * Generate a form field to spoof the HTTP verb used by forms.
     *
     * @param  string  $method
     * @return \Illuminate\Support\HtmlString
     */
    function method_field($method)
    {
        return new HtmlString('<input type="hidden" name="_method" value="'.$method.'">');
    }
}