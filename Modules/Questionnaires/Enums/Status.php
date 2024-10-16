<?php


namespace Modules\Questionnaires\Enums;

enum Status: string {
    case answered = 'answered';
    case not_answered = 'answered_not';
}
