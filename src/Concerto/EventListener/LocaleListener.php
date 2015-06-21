<?php

/*
 * This file is part of the Concerto framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Concerto\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\LocaleListener as BaseLocaleListener;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RequestContextAwareInterface;
use Concerto\Application;

/**
 * Initializes the locale based on the current request.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LocaleListener extends BaseLocaleListener
{
    protected $app;

    public function __construct(Application $app, RequestContextAwareInterface $router = null, RequestStack $requestStack = null)
    {
        parent::__construct($app['locale'], $router, $requestStack);

        $this->app = $app;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        parent::onKernelRequest($event);

        $this->app['locale'] = $event->getRequest()->getLocale();
    }
}
