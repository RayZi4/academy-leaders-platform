<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case REVIEW = 'review';
    case REVISION = 'revision';
    case READY_TO_SEND = 'ready_to_send';
    case SENT_TO_CUSTOMER = 'sent_to_customer';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::NEW => 'Новая заявка',
            self::IN_PROGRESS => 'В работе',
            self::REVIEW => 'На проверке',
            self::REVISION => 'Доработка',
            self::READY_TO_SEND => 'Готов к отправке',
            self::SENT_TO_CUSTOMER => 'Отправлен заказчику',
            self::COMPLETED => 'Завершён',
        };
    }

    public static function forSelect(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->value] = $case->label();
        }
        return $result;
    }
}
