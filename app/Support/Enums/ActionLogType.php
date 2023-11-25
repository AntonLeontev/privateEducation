<?php

namespace App\Support\Enums;

enum ActionLogType: string
{
    case subscribtion = 'subscription';
    case reading = 'reading';
    case listen = 'listen';
    case viewVideo = 'view video';
    case viewPresentation = 'view presentation';
    case passiveView = 'passive view';
}
