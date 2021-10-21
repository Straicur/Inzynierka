<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_Routes_DefaultService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'nelmio_api_doc.routes.default' shared service.
     *
     * @return \Symfony\Component\Routing\RouteCollection
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/routing/RouteCollection.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Routing/FilteredRouteCollectionBuilder.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Util/ControllerReflector.php';

        return $container->privates['nelmio_api_doc.routes.default'] = (new \Nelmio\ApiDocBundle\Routing\FilteredRouteCollectionBuilder(($container->privates['annotations.cached_reader'] ?? $container->load('getAnnotations_CachedReaderService')), ($container->privates['nelmio_api_doc.controller_reflector'] ?? ($container->privates['nelmio_api_doc.controller_reflector'] = new \Nelmio\ApiDocBundle\Util\ControllerReflector($container))), 'default', ['path_patterns' => [0 => '^/([a-z]+)(?!/doc$)'], 'host_patterns' => [], 'name_patterns' => [], 'with_annotation' => false]))->filter(($container->services['router'] ?? $container->getRouterService())->getRouteCollection());
    }
}
