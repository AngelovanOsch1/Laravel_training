<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     schema="Series",
 *     type="object",
 *     title="Series",
 *     required={"id", "title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Attack on Titan"),
 *     @OA\Property(
 *         property="genres",
 *         type="array",
 *         @OA\Items(type="string", example="Action")
 *     ),
 *     @OA\Property(
 *         property="studios",
 *         type="array",
 *         @OA\Items(type="string", example="MAPPA")
 *     ),
 *     @OA\Property(
 *         property="themes",
 *         type="array",
 *         @OA\Items(type="string", example="Post-apocalyptic")
 *     )
 * )
 */
class SeriesSchema {}
