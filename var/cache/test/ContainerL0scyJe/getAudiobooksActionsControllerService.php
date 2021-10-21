<?php

namespace ContainerL0scyJe;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAudiobooksActionsControllerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'App\Controller\AudiobooksActionsController' shared autowired service.
     *
     * @return \App\Controller\AudiobooksActionsController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/MyController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/AudiobooksActionsController.php';

        $container->services['App\\Controller\\AudiobooksActionsController'] = $instance = new \App\Controller\AudiobooksActionsController();

        $instance->setContainer(($container->privates['.service_locator.W9y3dzm'] ?? $container->load('get_ServiceLocator_W9y3dzmService'))->withContext('App\\Controller\\AudiobooksActionsController', $container));

        return $instance;
    }
}
