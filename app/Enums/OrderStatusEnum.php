<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SENDING = 'sending';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}

