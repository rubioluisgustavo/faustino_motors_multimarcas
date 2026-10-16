<?php

function sanitizeVehicleDescription(string $description): string
{
    $allowedTags = '<strong><b><em><i><u><br><p><div><ul><ol><li>';
    $description = strip_tags($description, $allowedTags);
    $description = preg_replace(
        '/<(strong|b|em|i|u|p|div|ul|ol|li)\b[^>]*>/i',
        '<$1>',
        $description
    ) ?? '';

    return preg_replace('/<br\b[^>]*>/i', '<br>', $description) ?? '';
}

function vehicleDescriptionHtml(string $description): string
{
    if (!preg_match('/<\/?(?:strong|b|em|i|u|br|p|div|ul|ol|li)\b/i', $description)) {
        return nl2br(htmlspecialchars($description, ENT_QUOTES, 'UTF-8'));
    }

    return sanitizeVehicleDescription($description);
}
