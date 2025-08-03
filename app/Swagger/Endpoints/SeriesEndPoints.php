<?php

namespace App\Swagger\Endpoints;

/**
 * @OA\Tag(
 *     name="Series",
 *     description="Operations about series"
 * )
 */
class SeriesEndpoints
{
    /**
     * @OA\Get(
     *     path="/api/series",
     *     summary="Get series list",
     *     tags={"Series"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Series"))
     *     )
     * )
     */
    public function index() {}
}
