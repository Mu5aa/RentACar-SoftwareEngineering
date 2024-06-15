<?php

/**
 * @OA\Info(
 *   title="API",
 *   description="CarBook API",
 *   version="1.0",
 *   @OA\Contact(
 *     email="amir.basovic@stu.ibu.edu.ba",
 *     name="Amir Basovic"
 *   )
 * ),
 * @OA\OpenApi(
 *   @OA\Server(
 *       url=BASE_URL
 *   )
 * )
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
