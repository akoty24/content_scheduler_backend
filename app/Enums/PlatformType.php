<?php

namespace App\Enums;

enum PlatformType: string
{
    case TWITTER = 'twitter';
    case INSTAGRAM = 'instagram';
    case LINKEDIN = 'linkedin';
    case FACEBOOK = 'facebook';
}