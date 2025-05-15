<?php

namespace App\ErrorMessages;

enum ErrorMessages: string
{
    case Mimes = 'Mimes';
    case Max = 'Max';
    case Image = 'Image';
    case Unknown = 'Unknown';

    private static function getMessage(self $error): string
    {
        return match ($error) {
            self::Mimes => 'Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.',
            self::Max => 'The file size is too large. Maximum size is 10MB.',
            self::Image => 'The file must be an image.',
            self::Unknown => 'Unknown error.',
        };
    }

    public static function getErrorMessage(array $errors): array
    {
        return array_map(function ($error) {
            return match (strtolower($error)) {
                'mimes' => self::getMessage(self::Mimes),
                'max' => self::getMessage(self::Max),
                'image' => self::getMessage(self::Image),
                default => self::getMessage(self::Unknown),
            };
        }, $errors);
    }
}
