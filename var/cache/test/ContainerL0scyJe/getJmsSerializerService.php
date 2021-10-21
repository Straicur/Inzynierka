<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getJmsSerializerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'jms_serializer' shared service.
     *
     * @return \JMS\Serializer\Serializer
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/SerializerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/ArrayTransformerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Serializer.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Visitor/Factory/DeserializationVisitorFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Visitor/Factory/XmlDeserializationVisitorFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/ContextFactory/SerializationContextFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/ContextFactory/DeserializationContextFactoryInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer-bundle/ContextFactory/ConfiguredContextFactory.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Type/ParserInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/jms/serializer/src/Type/Parser.php';

        return $container->services['jms_serializer'] = new \JMS\Serializer\Serializer(($container->privates['jms_serializer.metadata_factory'] ?? $container->load('getJmsSerializer_MetadataFactoryService')), [2 => ($container->privates['jms_serializer.deserialization_graph_navigator_factory'] ?? $container->load('getJmsSerializer_DeserializationGraphNavigatorFactoryService')), 1 => ($container->privates['jms_serializer.serialization_graph_navigator_factory'] ?? $container->load('getJmsSerializer_SerializationGraphNavigatorFactoryService'))], ['json' => ($container->privates['jms_serializer.json_serialization_visitor'] ?? $container->load('getJmsSerializer_JsonSerializationVisitorService')), 'xml' => ($container->privates['jms_serializer.xml_serialization_visitor'] ?? $container->load('getJmsSerializer_XmlSerializationVisitorService'))], ['json' => ($container->privates['jms_serializer.json_deserialization_visitor'] ?? $container->load('getJmsSerializer_JsonDeserializationVisitorService')), 'xml' => ($container->privates['jms_serializer.xml_deserialization_visitor'] ?? ($container->privates['jms_serializer.xml_deserialization_visitor'] = new \JMS\Serializer\Visitor\Factory\XmlDeserializationVisitorFactory()))], ($container->services['jms_serializer.serialization_context_factory'] ?? ($container->services['jms_serializer.serialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory())), ($container->services['jms_serializer.deserialization_context_factory'] ?? ($container->services['jms_serializer.deserialization_context_factory'] = new \JMS\SerializerBundle\ContextFactory\ConfiguredContextFactory())), ($container->privates['jms_serializer.type_parser'] ?? ($container->privates['jms_serializer.type_parser'] = new \JMS\Serializer\Type\Parser())));
    }
}
