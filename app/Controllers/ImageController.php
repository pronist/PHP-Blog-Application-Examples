<?php

namespace App\Controllers;

use App\Services\ImageService;

class ImageController
{
    /**
     * @var array $accepts
     */
    private static $accepts = [
        'png', 'jpg'
    ];

    /**
     * @var string $uploadDirectory
     */
    private static $uploadDirectory = __DIR__ . '/../../storage/app/images/';

    /**
     * Upload a Image (POST)
     */
    public static function store()
    {
        $file = $_FILES['upload'];
        $filename = $_SESSION['user']->id . '_' . time() . '_' . hash('md5', $file['name']);

        echo ImageService::write($file, self::$accepts, self::$uploadDirectory . $filename);
    }

    /**
     * Get a Image (GET)
     *
     * @param string $path
     */
    public static function show($path)
    {
        echo ImageService::read(self::$uploadDirectory . basename($path));
    }
}
