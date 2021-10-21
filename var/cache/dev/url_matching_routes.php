<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/admin/login' => [[['_route' => 'app_admin_login', '_controller' => 'App\\Controller\\AdminController::login'], null, ['POST' => 0], null, false, false, null]],
        '/admin/logout' => [[['_route' => 'app_admin_logoutadmin', '_controller' => 'App\\Controller\\AdminController::logoutAdmin'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/addAudiobook' => [[['_route' => 'audiobooks_add', '_controller' => 'App\\Controller\\AudiobooksActionsController::addAudiobook'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/getAudiobook' => [[['_route' => 'audiobooks_get', '_controller' => 'App\\Controller\\AudiobooksActionsController::getZipFile'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/sendZipFile' => [[['_route' => 'sendZipFile', '_controller' => 'App\\Controller\\AudiobooksActionsController::sendZipFile'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/removeAudiobook' => [[['_route' => 'removeAudiobook', '_controller' => 'App\\Controller\\AudiobooksActionsController::removeAudiobook'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/getJsonAudiobook' => [[['_route' => 'getJsonAudiobook', '_controller' => 'App\\Controller\\AudiobooksActionsController::getJsonAudiobook'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/editAudiobook' => [[['_route' => 'editAudiobook', '_controller' => 'App\\Controller\\AudiobooksActionsController::editAudiobook'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/getSets' => [[['_route' => 'audiobooks_gets', '_controller' => 'App\\Controller\\AudiobooksSetsController::getSets'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/addSet' => [[['_route' => 'add_audiobook_sets', '_controller' => 'App\\Controller\\AudiobooksSetsController::addNewSet'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/getSetData' => [[['_route' => 'get_sets_data', '_controller' => 'App\\Controller\\AudiobooksSetsController::getSetData'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/changeSetName' => [[['_route' => 'change_set_name', '_controller' => 'App\\Controller\\AudiobooksSetsController::changeSetName'], null, ['POST' => 0], null, false, false, null]],
        '/audiobooks/deleteSet' => [[['_route' => 'delete_set', '_controller' => 'App\\Controller\\AudiobooksSetsController::deleteSet'], null, ['POST' => 0], null, false, false, null]],
        '/user/login' => [[['_route' => 'user_login', '_controller' => 'App\\Controller\\LoginUser::loginUser'], null, ['POST' => 0], null, false, false, null]],
        '/user/logout' => [[['_route' => 'user_logout', '_controller' => 'App\\Controller\\LoginUser::logoutUser'], null, ['POST' => 0], null, false, false, null]],
        '/user/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, ['POST' => 0], null, false, false, null]],
        '/verify/email' => [[['_route' => 'app_verify_email', '_controller' => 'App\\Controller\\RegistrationController::verifyUserEmail'], null, ['GET' => 0], null, false, false, null]],
        '/admin/users' => [[['_route' => 'user_info', '_controller' => 'App\\Controller\\UsersActionsController::userInfo'], null, ['POST' => 0], null, false, false, null]],
        '/admin/users/edit' => [[['_route' => 'user_edit', '_controller' => 'App\\Controller\\UsersActionsController::userEdit'], null, ['POST' => 0], null, false, false, null]],
        '/admin/users/delete' => [[['_route' => 'user_delete', '_controller' => 'App\\Controller\\UsersActionsController::userDelete'], null, ['POST' => 0], null, false, false, null]],
        '/api/doc' => [[['_route' => 'app.swagger_ui', '_controller' => 'nelmio_api_doc.controller.swagger_ui'], null, ['GET' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [
            [['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
