<?php


namespace KhairulImam\ROSWrapper;

use Exception;

class RollbackedException extends Exception
{

    private $failedCommand;
    private $rollbackedCommands = [];
    private $reason = "";

    public function __construct(Command $failedCommand, array $rollbackedCommands)
    {
        parent::__construct();
        $this->failedCommand = $failedCommand;
        $this->rollbackedCommands = $rollbackedCommands;
        $this->message = "Ada kesalahan ketika menjalankan proses " . $this->getFailedCommandName() . ', proses yang telah dijalankan sebelumnya telah di rollback. Proses yang di rollback yaitu: ' . $this->getRollbackedCommandNames();
    }

    public function getFailedCommandName()
    {
        return $this->failedCommand->name();
    }

    public function getRollbackedCommandNames()
    {
        $names = array_map(function ($item) {
            return $item->name();
        }, $this->rollbackedCommands);
        return join(", ", $names);
    }

    public function getFailedCommand() 
    {
        return $this->failedCommand;
    }

    public function getRollbackedCommands()
    {
        return $this->rollbackedCommands;
    }

    public function withReason($reason) 
    {
        $this->reason = $reason;
        return $this;
    }

    public function getReason() 
    {
        return $this->reason;
    }

}