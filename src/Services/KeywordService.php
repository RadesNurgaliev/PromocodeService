<?php

namespace App\Services;

class KeywordService
{
    public static function createNewKeyword(): string
    {
        //@TODO It would be better to use more reliable unique generator
        return hash('tiger160,4', uniqid());
    }
}