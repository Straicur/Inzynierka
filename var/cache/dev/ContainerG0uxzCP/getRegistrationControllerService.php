<?php

namespace ContainerG0uxzCP;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getRegistrationControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\RegistrationController' shared autowired service.
     *
     * @return \App\Controller\RegistrationController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/MyController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/RegistrationController.php';
        include_once \dirname(__DIR__, 4).'/src/Security/EmailVerifier.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfonycasts/verify-email-bundle/src/VerifyEmailHelperInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfonycasts/verify-email-bundle/src/VerifyEmailHelper.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/UriSigner.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfonycasts/verify-email-bundle/src/Util/VerifyEmailQueryUtility.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfonycasts/verify-email-bundle/src/Generator/VerifyEmailTokenGenerator.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/MailerInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/Mailer.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/Transport/TransportInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/Transport/Transports.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/mailer/Transport.php';

        $container->services['App\\Controller\\RegistrationController'] = $instance = new \App\Controller\RegistrationController(new \App\Security\EmailVerifier(new \SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelper(($container->services['router'] ?? $container->getRouterService()), new \Symfony\Component\HttpKernel\UriSigner($container->getEnv('APP_SECRET'), 'signature'), new \SymfonyCasts\Bundle\VerifyEmail\Util\VerifyEmailQueryUtility(), new \SymfonyCasts\Bundle\VerifyEmail\Generator\VerifyEmailTokenGenerator($container->getEnv('APP_SECRET')), 3600), new \Symfony\Component\Mailer\Mailer((new \Symfony\Component\Mailer\Transport(new RewindableGenerator(function () use ($container) {
            yield 0 => $container->load('getMailer_TransportFactory_GmailService');
            yield 1 => $container->load('getMailer_TransportFactory_NullService');
            yield 2 => $container->load('getMailer_TransportFactory_SendmailService');
            yield 3 => $container->load('getMailer_TransportFactory_NativeService');
            yield 4 => $container->load('getMailer_TransportFactory_SmtpService');
        }, 5)))->fromStrings(['main' => $container->getEnv('MAILER_DSN')]), NULL, ($container->services['event_dispatcher'] ?? $container->getEventDispatcherService())), ($container->services['doctrine.orm.default_entity_manager'] ?? $container->load('getDoctrine_Orm_DefaultEntityManagerService'))));

        $instance->setContainer(($container->privates['.service_locator.W9y3dzm'] ?? $container->load('get_ServiceLocator_W9y3dzmService'))->withContext('App\\Controller\\RegistrationController', $container));

        return $instance;
    }
}
