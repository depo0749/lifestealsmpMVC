<?php
class Router {
    private $routes = [];
    private $params = [];
    private $namespace = '';
    
    public function add($route, $params = []) {
        // Route'u regex'e çevir
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        
        $this->routes[$route] = $params;
    }
    
    public function match($url) {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    
    public function dispatch($url) {
        $url = $this->removeQueryStringVariables($url);
        
        if ($this->match($url)) {
            $controller = $this->namespace . $this->params['controller'] . 'Controller';
            
            if (class_exists($controller)) {
                $controller_object = new $controller();
                
                $action = $this->params['action'];
                if (method_exists($controller_object, $action)) {
                    return call_user_func_array([$controller_object, $action], $this->params);
                } else {
                    throw new Exception("Method {$action} in controller {$controller} not found");
                }
            } else {
                throw new Exception("Controller class {$controller} not found");
            }
        } else {
            throw new Exception('No route matched.', 404);
        }
    }
    
    private function removeQueryStringVariables($url) {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function getRoutes() {
        return $this->routes;
    }
    
    // API route'ları için
    public function api($route, $params = []) {
        $params['api'] = true;
        $this->add('api' . $route, $params);
    }
    
    // Admin route'ları için
    public function admin($route, $params = []) {
        $params['admin'] = true;
        $this->add('admin' . $route, $params);
    }
    
    // Resource route'ları için (CRUD)
    public function resource($name, $params = []) {
        $controller = $params['controller'] ?? ucfirst($name);
        
        // Index
        $this->add($name, [
            'controller' => $controller,
            'action' => 'index'
        ]);
        
        // Show
        $this->add($name . '/{id:\d+}', [
            'controller' => $controller,
            'action' => 'show'
        ]);
        
        // Create
        $this->add($name . '/create', [
            'controller' => $controller,
            'action' => 'create'
        ]);
        
        // Store
        $this->add($name, [
            'controller' => $controller,
            'action' => 'store'
        ], 'POST');
        
        // Edit
        $this->add($name . '/{id:\d+}/edit', [
            'controller' => $controller,
            'action' => 'edit'
        ]);
        
        // Update
        $this->add($name . '/{id:\d+}', [
            'controller' => $controller,
            'action' => 'update'
        ], 'PUT');
        
        // Delete
        $this->add($name . '/{id:\d+}', [
            'controller' => $controller,
            'action' => 'delete'
        ], 'DELETE');
    }
    
    // Middleware ekleme
    public function middleware($middleware, $routes = []) {
        foreach ($routes as $route) {
            if (isset($this->routes[$route])) {
                $this->routes[$route]['middleware'] = $middleware;
            }
        }
    }
    
    // Group route'ları
    public function group($prefix, $callback) {
        $previousNamespace = $this->namespace;
        $this->namespace .= $prefix . '\\';
        
        $callback($this);
        
        $this->namespace = $previousNamespace;
    }
    
    // Route cache
    public function cache($filename = 'routes.cache') {
        $cache = [
            'routes' => $this->routes,
            'timestamp' => time()
        ];
        
        file_put_contents($filename, serialize($cache));
    }
    
    // Route cache'den yükleme
    public function loadCache($filename = 'routes.cache') {
        if (file_exists($filename)) {
            $cache = unserialize(file_get_contents($filename));
            if (isset($cache['routes'])) {
                $this->routes = $cache['routes'];
                return true;
            }
        }
        return false;
    }
}
?>
