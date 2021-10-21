<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getNelmioApiDoc_ObjectModel_PropertyDescribers_StringService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'nelmio_api_doc.object_model.property_describers.string' shared service.
     *
     * @return \Nelmio\ApiDocBundle\PropertyDescriber\StringPropertyDescriber
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/PropertyDescriber/PropertyDescriberInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/nelmio/api-doc-bundle/PropertyDescriber/StringPropertyDescriber.php';

        return $container->privates['nelmio_api_doc.object_model.property_describers.string'] = new \Nelmio\ApiDocBundle\PropertyDescriber\StringPropertyDescriber();
    }
}
