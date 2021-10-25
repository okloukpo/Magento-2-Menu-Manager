<?php

/**
 * Naxero.com
 * Professional ecommerce integrations for Magento.
 *
 * PHP version 7
 *
 * @category  Magento2
 * @package   Naxero
 * @author    Platforms Development Team <contact@naxero.com>
 * @copyright © Naxero.com all rights reserved
 * @license   https://opensource.org/licenses/mit-license.html MIT License
 * @link      https://www.naxero.com
 */

namespace Naxero\MenuManager\Console\Command\Sitemap;

use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Generate sitemap console command
 */
class Generate extends Command
{
    /**
     * @var String
     */
    const SITEMAP_ID = 'id';

    /**
     * @var String
     */
    const SITEMAP_NAME = 'name';

    /**
     * @var Config
     */
    public $configHelper;

    /**
     * @var Xml
     */
    public $sitemapXmlHelper;

    /**
     * UpdateKeywords command class constructor.
     */
    public function __construct(
        \Naxero\MenuManager\Helper\Config $configHelper,
        \Naxero\MenuManager\Helper\Sitemap\Xml $sitemapXmlHelper
    ) {
        $this->configHelper = $configHelper;
        $this->sitemapXmlHelper = $sitemapXmlHelper;

        parent::__construct();
    }

    /**
     * Define the command.
     */
    public function configure()
    {
        $this->setName('naxero:sitemaps:generate');
        $this->setDescription(__('Generate XML sitemaps'));
        $this->setHelp(__('Generate XML sitemaps'));
        $this->setDefinition($this->getCommandOptions());

        parent::configure();
    }

    /**
     * Run the CLI command.
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Can run command
        if ($this->configHelper->canRunCommand()) {
            try {
                // Prepare variables
                $entityId = (int) $input->getOption(self::SITEMAP_ID);
                $fileName = (int) $input->getOption(self::SITEMAP_NAME);

                // Run the command
                if ($entityId > 0) {
                    $this->sitemapXmlHelper->generateSitemap([
                        'id' => $entityId
                    ]);
                } elseif (!empty($fileName)) {
                    $this->sitemapXmlHelper->generateSitemaps([
                        'file_name' => $fileName
                    ]);
                } else {
                    $this->sitemapXmlHelper->generateSitemaps();
                }

                // Success message
                $output->writeln(
                    __('<info>Sitemaps successfully generated.</info>')
                );
            } catch (\Exception $e) {
                $output->writeln(__($e->getMessage()));
            }
        } else {
            $output->writeln(
                __('<error>Command unavailable. Check the module settings.</error>')
            );
        }
    }

    /**
     * Get the command options
     */
    public function getCommandOptions()
    {
        return [
            new InputOption(
                self::SITEMAP_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                __('Optional sitemap ID')
            ),
            new InputOption(
                self::SITEMAP_NAME,
                null,
                InputOption::VALUE_OPTIONAL,
                __('Optional sitemap name')
            )
        ];
    }
}
