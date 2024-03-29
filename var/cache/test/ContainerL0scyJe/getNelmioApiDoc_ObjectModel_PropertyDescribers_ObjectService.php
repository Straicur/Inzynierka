<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_ObjectModel_PropertyDescribers_ObjectService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'nelmio_api_doc.object_model.property_describers.object' shared service.
     *
     * @return \Nelmio\ApiDocBundle\PropertyDescriber\ObjectPropertyDescriber
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/PropertyDescriber/PropertyDescriberInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Describer/ModelRegistryAwareInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/Describer/ModelRegistryAwareTrait.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/PropertyDescriber/ObjectPropertyDescriber.php';

        return $container->privates['nelmio_api_doc.object_model.property_describers.object'] = new \Nelmio\ApiDocBundle\PropertyDescriber\ObjectPropertyDescriber();
    }
}
