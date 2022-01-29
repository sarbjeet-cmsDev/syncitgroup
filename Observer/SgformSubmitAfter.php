<?php

namespace Syncitgroup\Sgform\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;

/**
 * Observer SgformSubmitAfter
 */
class SgformSubmitAfter implements ObserverInterface
{
    const LOGFILE = 'sgform.txt';
    /**
     * @var DirectoryList
     */
    private $directoryList;
 
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var File
     */
    private $fileDriver;

    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @param DirectoryList $directoryList [description]
     * @param Filesystem    $filesystem    [description]
     * @param File $fileDriver
     * @param RemoteAddress $remoteAddress
     */
    public function __construct(
        DirectoryList $directoryList,
        Filesystem $filesystem,
        File $fileDriver,
        RemoteAddress $remoteAddress
    ) {
        $this->directoryList = $directoryList;
        $this->filesystem = $filesystem;
        $this->fileDriver = $fileDriver;
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @param  Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $writer = $this->filesystem->getDirectoryWrite(
            DirectoryList::VAR_DIR
        );

        $varPath = $this->directoryList->getPath('var');

        $fileName = 'log' . '/' . self::LOGFILE;

        if ($this->fileDriver->isExists($varPath . '/' . $fileName)) {
            $stream = $writer->openFile($fileName, 'a');
        } else {
            $stream = $writer->openFile($fileName, 'w+', 0777);
        }
        
        $stream->lock();
        $stream->write($this->remoteAddress->getRemoteAddress() . PHP_EOL);
        $stream->unlock();
        $stream->close();
    }
}
