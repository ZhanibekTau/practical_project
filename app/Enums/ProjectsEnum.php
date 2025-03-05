<?php

namespace App\Enums;

enum ProjectsEnum {
    public const ACTIVE = 'active';
    public const PLANNED = 'planned';
    public const COMPLETED = 'completed';

    public const ACCEPTED_STATUSES = [
      self::ACTIVE,
      self::PLANNED,
      self::COMPLETED,
    ];
}
