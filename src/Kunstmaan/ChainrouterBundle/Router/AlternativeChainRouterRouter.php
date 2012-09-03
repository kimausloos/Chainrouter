<?php

namespace Kunstmaan\ChainrouterBundle\Router;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

class AlternativeChainRouterRouter implements RouterInterface {

    private $context;
    private $routeCollection;
    private $urlGenerator;

    public function __construct($container) {
        $this->context = new RequestContext();
        $this->context->fromRequest($container->get('request'));

        $this->routeCollection = new RouteCollection();

        $this->routeCollection->add('test_route_greet', new Route('/{name}/hello', array('_controller' => 'KunstmaanChainrouterBundle:Default:alternative')));
    }

    public function getRouteCollection() {
        return $this->routeCollection;
    }

    public function match($pathinfo) {
        $urlMatcher = new UrlMatcher($this->routeCollection, $this->context);

        return $urlMatcher->match($pathinfo);
    }

    public function generate($name, $parameters = array(), $absolute = false) {
        $this->urlGenerator = new UrlGenerator($this->routeCollection, $this->context);

        return $this->urlGenerator->generate($name, $parameters, $absolute);
    }

    /**
     * Sets the request context.
     *
     * @param RequestContext $context The context
     *
     * @api
     */
    public function setContext(RequestContext $context)
    {
        $this->context = $context;
    }

    /**
     * Gets the request context.
     *
     * @return RequestContext The context
     *
     * @api
     */
    public function getContext()
    {
        return $this->context;
    }
}