<?php

namespace UrlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use UrlBundle\Entity\Url;
use UrlBundle\Entity\UrlInfo;

class GetInfoCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('url:get-info')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('argument');

        if ($input->getOption('option')) {
            // ...
        }

        $repository = $this->getContainer()->get('doctrine')->getRepository(Url::class);
        /** @var Url $url */
        $url = $repository->getSiteWithoutInfo();

        $infoService = $this->getContainer()->get('url_bundle.get_info.service');
        $infoService->setUrl($url);
        $htmlMeta = $infoService->getHtmlMeta();
        $requestMeta = $infoService->getRequestMeta();

        $screenService = $this->getContainer()->get('url_bundle.screenshotter.service');
        $file = $screenService->capture($url);

        $info = new UrlInfo();
        $info->setIp($requestMeta['primary_ip']);
        $info->setTitle($htmlMeta['title'] ?? '');
        $info->setDescription($htmlMeta['description'] ? mb_substr($htmlMeta['description'], 0, 255, 'UTF-8') :  '');

        $info->setScreenshot($file);

        $info->setCreated(new \DateTime());
        $url->setInfo($info);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($url);
        $em->flush();

        $output->writeln('Screenshot was stored to ' . $file);
        $output->writeln('UrlInfo was created');
    }

}
