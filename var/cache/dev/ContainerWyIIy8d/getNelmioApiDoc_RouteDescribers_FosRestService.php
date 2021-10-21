<?php

namespace ContainerWyIIy8d;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_RouteDescribers_FosRestService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'nelmio_api_doc.route_describers.fos_rest' shared service.
     *
     * @return \Nelmio\ApiDocBundle\RouteDescriber\FosRestDescriber
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/RouteDescriber/RouteDescriberInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/RouteDescriber/RouteDescriberTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/RouteDescriber/FosRestDescriber.php';

        return $container->privates['nelmio_api_doc.route_describers.fos_rest'] = new \Nelmio\ApiDocBundle\RouteDescriber\FosRestDescriber(($container->privates['annotations.cached_reader'] ?? $container->load('getAnnotations_CachedReaderService')));
    }
}
