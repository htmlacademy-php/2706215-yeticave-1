<?php

declare(strict_types=1);

/**
 * Saves an uploaded image file and returns its public URL.
 *
 * The file is validated by upload status, size, extension and MIME type.
 * The saved file name is generated from the file hash.
 *
 * TODO: Split this function into smaller functions:
 * - validate_uploaded_file()
 * - get_uploaded_file_extension()
 * - get_uploaded_file_mime_type()
 * - generate_uploaded_file_name()
 *
 * @param string $input_name File input name from the HTML form.
 * @return string|false Public file URL on success, false on failure.
 */
function save_uploaded_file(string $input_name): string|false
{
    if (
        empty($_FILES[$input_name]) ||
        empty($_FILES[$input_name]['name']) ||
        empty($_FILES[$input_name]['tmp_name']) ||
        $_FILES[$input_name]['error'] !== UPLOAD_ERR_OK
    ) {
        return false;
    }

    $file_name = $_FILES[$input_name]['name'];
    $tmp_name = $_FILES[$input_name]['tmp_name'];

    $file_size = $_FILES[$input_name]['size'];

    if ($file_size > MAX_UPLOADED_FILE_SIZE) {
        return false;
    }

    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $mime_type = mime_content_type($tmp_name);

    if (
        !isset(ALLOWED_IMAGE_TYPES[$extension]) ||
        ALLOWED_IMAGE_TYPES[$extension] !== $mime_type
    ) {
        return false;
    }

    $hash = md5_file($tmp_name);

    if ($hash === false) {
        return false;
    }

    $new_file_name = $hash . '.' . $extension;
    $file_path = UPLOADS_DIR . '/' . $new_file_name;
    $file_url = UPLOADS_URL . '/' . $new_file_name;

    $saved = move_uploaded_file($tmp_name, $file_path);

    return $saved ? $file_url : false;
}
