<?php
declare(strict_types=1);

function upload_imagem_questao(array $file): array
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'filename' => null];
    }
    if (($file['error'] ?? 0) !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'msg' => 'Falha no upload da imagem.'];
    }
    if (($file['size'] ?? 0) > 2 * 1024 * 1024) {
        return ['ok' => false, 'msg' => 'Imagem deve ter no máximo 2 MB.'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $map = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];
    if (!isset($map[$mime])) {
        return ['ok' => false, 'msg' => 'Formato não permitido. Use JPG, PNG ou WebP.'];
    }

    $name = bin2hex(random_bytes(12)) . '.' . $map[$mime];
    $dest = APP_ROOT . '/uploads/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return ['ok' => false, 'msg' => 'Não foi possível salvar a imagem.'];
    }
    return ['ok' => true, 'filename' => $name];
}
