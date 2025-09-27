<?php

if (!function_exists('uploadFile')) {
    function uploadFile($file, $folder = 'uploads')
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        // Create folder path in public directory
        $publicPath = public_path($folder);
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0755, true);
        }

        // Generate unique filename
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Move file to public folder
        $file->move($publicPath, $fileName);
        
        // Return path relative to public folder (for storing in database)
        return $folder . '/' . $fileName;
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            unlink(public_path($filePath));
            return true;
        }
        return false;
    }
}

if (!function_exists('getFileUrl')) {
    function getFileUrl($filePath)
    {
        if ($filePath && file_exists(public_path($filePath))) {
            return asset($filePath);
        }
        return null;
    }
}