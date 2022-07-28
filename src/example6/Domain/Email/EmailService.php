<?php

namespace Demo\Domain\Email;

use Demo\Domain\Base\DomainService;
use Demo\Domain\Email\SendToAdminNotify\SendToAdminNotifyCommand;

class EmailService extends DomainService
{


    public function sendToAdminNotify(SendToAdminNotifyCommand $command)
    {
        $this->commandBus->handle($command);
    }

}