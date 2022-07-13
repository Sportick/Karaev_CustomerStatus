<?php

namespace Karaev\CustomerStatus\Api;

interface CustomerStatusDataInterface
{
    public const STATUS = 'status';

    public const LABEL_STATUS_DISABLE = 'Disable';
    public const LABEL_STATUS_ENABLE = 'Enable';

    public const VALUE_STATUS_DISABLE = 0;
    public const VALUE_STATUS_ENABLE = 1;
}
