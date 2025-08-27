<?php

namespace Core;

class Router {
    protected $currentController = 'Controllers\\Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->getUrl();

        // Look for controller in controllers folder
        // ucwords will capitalize the first letter
        if (isset($url[0]) && file_exists(APP_ROOT . '/src/Controllers/' . ucwords($url[0]) . '.php')) {
            // If exists, set as current controller
            $this->currentController = 'Controllers\\' . ucwords($url[0]);
            // Unset 0 Index
            unset($url[0]);
        }

        // Instantiate the controller class
        $this->currentController = new $this->currentController;

        // Check for the second part of url (method)
        if (isset($url[1])) {
            // Check to see if method exists in controller
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                // Unset 1 index
                unset($url[1]);
            }
        }

        // Get params - The rest of the url parts
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
