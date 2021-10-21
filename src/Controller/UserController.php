<?php

namespace App\Controller;

use App\Entity\Institution;
use App\Entity\User;
use App\JsonModels\GetUserJsonModel;
use App\Model\AdminAuthSuccessModel;
use App\Model\UserInfoSuccessModel;
use App\Tools\DBTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends MyController
{
    /**
     *
     * @Route("/user/edit_password", name="edit_password", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserInfoQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The server could not understand the request due to invalid syntax"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized action user"
     * )
     *
     * @SWG\Response(
     *     response=501,
     *     description="Service configuration is incorrect"
     * )
     *
     * @SWG\Tag(name="Admin EP")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userEditPassword(Request $request): Response{


    }
    /**
     *
     * @Route("/user/delete", name="user_delete", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserInfoQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct",
     *     @Model(type=App\Model\AdminAuthSuccessModel::class)
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The server could not understand the request due to invalid syntax"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized action user"
     * )
     *
     * @SWG\Response(
     *     response=501,
     *     description="Service configuration is incorrect"
     * )
     *
     * @SWG\Tag(name="Admin EP")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userDelete(Request $request): Response{

    }
}