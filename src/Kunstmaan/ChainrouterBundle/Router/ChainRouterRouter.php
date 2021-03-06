<?php

namespace Kunstmaan\ChainrouterBundle\Router;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\HttpFoundation\Request;

class ChainRouterRouter implements RouterInterface {

    private $context;
    private $routeCollection;
    private $urlGenerator;
    private $container;

    public function __construct($container) {
        $this->container = $container;

        $this->routeCollection = new RouteCollection();

        $this->routeCollection->add('test_route_greet', new Route('/{_locale}/hello/{name}', array('_controller' => 'KunstmaanChainrouterBundle:Default:index')));
    }


    public function getRouteCollection() {
        return $this->routeCollection;
    }


    public function match($pathinfo) {
        $urlMatcher = new UrlMatcher($this->routeCollection, $this->getContext());

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
        if(!isset($this->context)) {
            $this->context = new RequestContext();
            $this->context->fromRequest($this->container->get('request'));
        }
        return $this->context;
    }
}