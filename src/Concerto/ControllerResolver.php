<?php

/*
 * This file is part of the Concerto framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Concerto;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as BaseControllerResolver;
use Symfony\Component\HttpFoundation\Request;

/**
 * Adds Application as a valid argument for controllers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ControllerResolver extends BaseControllerResolver
{
    protected $app;

    /**
     * Constructor.
     *
     * @param Application     $app    An Application instance
     * @param LoggerInterface $logger A LoggerInterface instance
     */
    public function __construct(Application $app, LoggerInterface $logger = null)
    {
        $this->app = $app;

        parent::__construct($logger);
    }

    protected function doGetArguments(Request $request, $controller, array $parameters)
    {
        foreach ($parameters as $param) {
            if ($param->getClass() && $param->getClass()->isInstance($this->app)) {
                $request->attributes->set($param->getName(), $this->app);

                break;
            }
        }

        return parent::doGetArguments($request, $controller, $parameters);
    }

    /**
     * Returns a callable for the given controller.
     *
     * @param string $controller A Controller string
     *
     * @return mixed A PHP callable
     *
     * @throws \InvalidArgumentException
     */
    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller, 2);
        
        $class  = '\\controllers\\' . $class . 'Controller';
        $method = $method . 'Action';

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
        }

        return array($this->instantiateController($class), $method);
    }
    
    protected function instantiateController($class) {
        
        $class = $class . "Controller";
        return new $class($this->app);
        
    }
}
