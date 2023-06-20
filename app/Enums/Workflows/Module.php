<?php

namespace App\Enums\Workflows;

enum Module: string
{
    case CER = 'CER';
    case TRANSFER = 'TRANSFER';
    case DISPOSE = 'DISPOSE';
}
