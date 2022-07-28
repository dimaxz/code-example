<?php

namespace Demo\Domain\Email\SendToAdminNotify;

use Demo\Domain\Base\ApplicationCommandInterface;
use Demo\Domain\Base\ApplicationHandler;

class SendToAdminNotifyHandler extends ApplicationHandler
{
    /**
     * @param SendToAdminNotifyCommand $command
     * @return void
     */
    public function handle(ApplicationCommandInterface $command): void
    {
        dump('send '. $command->getTask()->getName());
        $this->recordsEvents->record(new NotifyAdminWasSendingEvent());
    }


}