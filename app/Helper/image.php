<?php

function document_upload($file, $title = '')
{
    if ($file) {
        if ($file->extension() == 'pdf') {
            $imageName = 'poly2025_' . '-' . str_replace(' ', '-', $title) . '-' . rand(1, 999) . '.' . $file->extension();
            $directory = 'file-uploads/';
            $imgUrl = $directory . $imageName;
            $file->move($directory, $imageName);
            return $imgUrl;
        } else {
            $imageName = time() . rand(1, 999) . '.' . $file->extension();
            $directory = 'file-uploads/';
            $imgUrl = $directory . $imageName;
            $file->move($directory, $imageName);
            return $imgUrl;
        }
    }
    return null;
}

function image_upload($image, $title = '')
{
    if ($image) {
        $imageName = time() . rand(1, 999) . '.' . $image->extension();
        $directory = 'file-uploads/';
        $imgUrl = $directory . $imageName;
        $image->move($directory, $imageName);
        return $imgUrl;
    }
    return null;
}


function delete_image($imagePath)
{
    if ($imagePath) {
        $imagePath = public_path($imagePath);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}


function delete_image_special($imagePath)
{
    if ($imagePath) {
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
