<?php
/**
 * Copyright © Magmodules.eu. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Two\Gateway\Model\Log;

use Two\Gateway\Api\Config\RepositoryInterface as Config;
use Two\Gateway\Api\Log\RepositoryInterface as LogRepositoryInterface;
use Two\Gateway\Logger\DebugLogger;
use Two\Gateway\Logger\ErrorLogger;

/**
 * Logs repository class
 */
class Repository implements LogRepositoryInterface
{

    /**
     * @var DebugLogger
     */
    private $debugLogger;

    /**
     * @var ErrorLogger
     */
    private $errorLogger;

    /**
     * @var Config
     */
    private $config;

    /**
     * Repository constructor.
     *
     * @param DebugLogger $debugLogger
     * @param ErrorLogger $errorLogger
     * @param Config $config
     */
    public function __construct(
        DebugLogger $debugLogger,
        ErrorLogger $errorLogger,
        Config $config
    ) {
        $this->debugLogger = $debugLogger;
        $this->errorLogger = $errorLogger;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function addErrorLog(string $type, $data)
    {
        $this->errorLogger->addLog($type, $data);
    }

    /**
     * @inheritDoc
     */
    public function addLog(string $type, $data)
    {
        if ($this->config->isDebugMode()) {
            $this->addDebugLog($type, $data);
        } else {
            $this->addErrorLog($type, $data);
        }
    }

    /**
     * @inheritDoc
     */
    public function addDebugLog(string $type, $data)
    {
        $this->debugLogger->addLog($type, $data);
    }
}
