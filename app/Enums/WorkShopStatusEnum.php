<?php

namespace App\Enums;


use App\Traits\Enum\EnumTrait;

enum  WorkShopStatusEnum:string
{
    use EnumTrait;

    case pending='pending';
    case progress='progress';
    case finished='finished';
    case scheduling='scheduling';

}



