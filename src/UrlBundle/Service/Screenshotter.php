<?php

namespace UrlBundle\Service;

use Symfony\Component\Process\Process;
use Twig_Environment;

use UrlBundle\Entity\Url;

/**
 * Class Screenshotter
 *
 * @package UrlBundle\Service
 */
class Screenshotter
{
    /**
     * @var \Twig_LoaderInterface
     */
    private $_twigLoader;

    /**
     * @var string
     */
    private $_outputPath;

    /**
     * @var string
     */
    private $_tmpPath;

    /**
     * @var int
     */
    private $_imgWidth;

    /**
     * @var int
     */
    private $_imgHeight;

    /**
     * @var int
     */
    private $_timeout = 10;

    /**
     * @var int
     */
    private $_wait = 1;

    /**
     * Screenshotter constructor.
     *
     * @param \Twig_LoaderInterface $twigLoader
     * @param string                $outputPath
     * @param string                $tmpPath
     * @param int                   $imgWidth
     */
    public function __construct(
        \Twig_LoaderInterface $twigLoader,
        string $outputPath,
        string $tmpPath,
        int $imgWidth = 1024
    )
    {
        $this->_twigLoader = $twigLoader;
        $this->_outputPath = $outputPath;
        $this->_tmpPath = $tmpPath;
        $this->_imgWidth = $imgWidth;
        $this->_imgHeight = intval(9/16 * $imgWidth);
    }

    /**
     * @param int $timeout
     * @return Screenshotter
     */
    public function setTimeout(int $timeout) : Screenshotter
    {
        $this->_timeout = abs($timeout);
        return $this;
    }

    /**
     * @param int $wait
     * @return Screenshotter
     */
    public function setWait(int $wait) : Screenshotter
    {
        $this->_wait = abs($wait) * 1000;
        return $this;
    }

    /**
     * @param Url $url
     * @return string
     */
    public function capture(Url $url): string
    {
        $params = [
            'url' => $url->getUrl(),
            'filename' => $url->getShortUrl(),
            'width' => $this->_imgWidth,
            'height' => $this->_imgHeight,
            'wait' => $this->_wait,
        ];

        $jobPath = $this->_getJobFile($params);
        $fileName = $url->getShortUrl() . '.jpg';

        $filePath = $this->_getPathWithTrailingSlash($this->_outputPath) . $fileName;

        $process = $this->_getPhantomProcess($jobPath, $filePath)->setTimeout($this->_timeout);
        $process->mustRun();

        $this->_deleteJobFile($params);

        return $fileName;
    }

    /**
     * @param array $params
     * @return string
     */
    private function _getJobFile(array $params) : string
    {
        $jobPath = sprintf('%s/%s.js', $this->_tmpPath, $params['filename']);
        if (file_exists($jobPath)) {
            return $jobPath;
        }
        return $this->_buildJobFile($jobPath, $params);
    }

    /**
     * @param array $params
     * @return bool
     */
    private function _deleteJobFile(array $params) : bool
    {
        $jobPath = sprintf('%s/%s.js', $this->_tmpPath, $params['filename']);
        if (file_exists($jobPath)) {
            return unlink($jobPath);
        }
        return false;
    }

    /**
     * @param string $jobPath
     * @param array $params
     * @return string
     * @throws \Exception
     */
    private function _buildJobFile(string $jobPath, array $params) : string
    {
        $twig = new Twig_Environment($this->_twigLoader);

        $status = file_put_contents(
            $jobPath,
            $twig->render(
                'UrlBundle:Screenshotter:screenshot.js.twig',
                $params
            )
        );

        if ($status === false) {
            throw new \Exception(
                "Couldn't write the job file. Check that the provided cache path is correct, exists and is writable."
            );
        }
        return $jobPath;
    }

    /**
     * @param string $jobPath
     * @param string $screenshotPath
     * @return Process
     */
    private function _getPhantomProcess(string $jobPath, string $screenshotPath) : Process
    {
        $command = $this->_getPhantomPath();

        $command .= ' --ssl-protocol=any';
        $command .= ' --ignore-ssl-errors=true';

        $process = new Process(
            sprintf(
                '%s %s %s',
                $command,
                $jobPath,
                $screenshotPath
            )
        );
        $process->setWorkingDirectory($this->_getPathWithTrailingSlash(getcwd()));
        return $process;
    }

    /**
     * @return string
     */
    private function _getPhantomPath() : string
    {
        $phantomPath = 'bin/phantomjs';

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $phantomPath .= '.exe';
        }
        return $phantomPath;
    }

    /**
     * @param string $path
     * @return string
     */
    private function _getPathWithTrailingSlash(string $path) : string
    {
        return rtrim($path, '/') . '/';
    }
}
