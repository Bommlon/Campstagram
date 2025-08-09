<?php
function jpegCommentContainsString(string $image): string {
    $needle = 'Crappy Camp Cam';
    $data = file_get_contents($image);
    $offset = 2;

    while ($offset < strlen($data)) {
        if (ord($data[$offset]) != 0xFF) break;
        $marker = ord($data[$offset + 1]);
        $length = (ord($data[$offset + 2]) << 8) + ord($data[$offset + 3]);

        if ($marker === 0xFE) {
            $comment = substr($data, $offset + 4, $length - 2);
            return strpos($comment, $needle) !== false ? 'crappy' : 'normal';
        }

        $offset += 2 + $length;
    }

    return 'normal';
}
