<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_Controller_SwaggerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'nelmio_api_doc.controller.swagger' shared service.
     *
     * @return \Nelmio\ApiDocBundle\Controller\DocumentationController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Controller/DocumentationController.php';

        return $container->services['nelmio_api_doc.controller.swagger'] = new \Nelmio\ApiDocBundle\Controller\DocumentationController(($container->privates['nelmio_api_doc.generator_locator'] ?? $container->load('getNelmioApiDoc_GeneratorLocatorService')));
    }
}
