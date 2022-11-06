<?php

namespace App\Services;

class JsonArrayService
{
    public static function jsonToArray($path)
    {
        $content = file_get_contents($path);

        if (!$content) {
            return [];
        }

        return json_decode("[" . rtrim(trim(str_replace("}", "},", $content)), ",") . "]");
    }
}
