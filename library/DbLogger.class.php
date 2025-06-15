<?php

class DbLogger
{
    private $pdo;
    private $userId;


    public function __construct(PDO $pdo, $userId = null)
    {
        $this->pdo = $pdo;
        $this->userId = $userId;
    }

    public function log($level, $operationType, $actionType, $message, $userId = null)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO event_logs (level, operation_type, action_type, message, user_id, session_id)
            VALUES (:level, :operation_type, :action_type, :message, :user_id, :session_id)
        ");
        $stmt->execute([
            ':level'          => $level,
            ':operation_type' => $operationType,
            ':action_type'    => $actionType,
            ':message'        => $message,
            ':user_id'        => $userId !== null ? $userId : $this->userId,
            ':session_id'     => session_id(),
        ]);
    }

    public function info($operationType, $actionType, $message, $userId = null)
    {
        $this->log('INFO', $operationType, $actionType, $message, $userId);
    }

    public function warning($operationType, $actionType, $message, $userId = null)
    {
        $this->log('WARNING', $operationType, $actionType, $message, $userId);
    }

    public function error($operationType, $actionType, $message, $userId = null)
    {
        $this->log('ERROR', $operationType, $actionType, $message, $userId);
    }
}