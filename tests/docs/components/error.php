<?php
return [
    "type" => "object",
    "properties" => [
        "code" => [
            "type" => "integer",
            "format" => "int32",
        ],
        "message" => [
            "type" => "string",
        ],
    ],
    "required" => [
        "code",
        "message",
    ],
];
