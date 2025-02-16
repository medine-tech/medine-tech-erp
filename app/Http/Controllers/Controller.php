<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *      @OA\Server(
 *           description="Localhost Server",
 *           url="http://localhost",
 *       ),
 *      @OA\Info(
 *          title="MedineTech - ERP - Management Software API",
 *          version="0.0.0",
 *          description="Integration API Docs.",
 *          @OA\Contact(
 *              name="Developers Team",
 *              email="devs@medine.tech",
 *              url="https://medine.tech/"
 *          )
 *      ),
 *     @OA\Components(
 *          @OA\SecurityScheme(
 *              securityScheme="bearerAuth",
 *              type="http",
 *              scheme="bearer",
 *              bearerFormat="JWT"
 *          )
 *     )
 * )
 */
abstract class Controller
{
    //
}
