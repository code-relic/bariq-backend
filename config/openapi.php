<?php
use \OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "bariq api",
    description: "API documentation for bariq application"
)]
#[OA\Parameter(
    parameter: "Accept",
    name: "accept",
    in: "header",
    required: true,
    schema: new OA\Schema(
        type: "string",
        default: "application/json"
    )
)]

class OpenApiDocumentation
{
   
}