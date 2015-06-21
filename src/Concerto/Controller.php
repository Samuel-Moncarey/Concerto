<?php

namespace Concerto;

use Concerto\Application;

class Controller {
    
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }
    
}
