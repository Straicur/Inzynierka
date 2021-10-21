<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getJmsSerializer_MetadataFactoryService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'jms_serializer.metadata_factory' shared service.
     *
     * @return \Metadata\MetadataFactory
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/MetadataFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/AdvancedMetadataFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/MetadataFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Cache/CacheInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Cache/ClearableCacheInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/metadata/src/Cache/FileCache.php';

        $container->privates['jms_serializer.metadata_factory'] = $instance = new \Metadata\MetadataFactory(($container->privates['jms_serializer.metadata.lazy_loading_driver'] ?? $container->load('getJmsSerializer_Metadata_LazyLoadingDriverService')), 'Metadata\\ClassHierarchyMetadata', true);

        $instance->setCache(($container->privates['jms_serializer.metadata.cache.file_cache'] ?? ($container->privates['jms_serializer.metadata.cache.file_cache'] = new \Metadata\Cache\FileCache(($container->targetDir.''.'/jms_serializer')))));
        $instance->setIncludeInterfaces(false);

        return $instance;
    }
}
