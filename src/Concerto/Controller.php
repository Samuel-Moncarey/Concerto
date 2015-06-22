<?php

namespace Concerto;

use Concerto\Application;

class Controller {
    
    private $app;
    
    protected $request;

    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }
    
}
