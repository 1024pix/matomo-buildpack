<?php
namespace Piwik\Plugins\LicenseKeyCommands\Commands;
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

use Piwik\Common;
use Piwik\Plugin\ConsoleCommand;
use Piwik\Plugins\Marketplace\LicenseKey;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to selectively delete visits.
 */
class SetLicenseKey extends ConsoleCommand
{
    protected function configure()
    {
        $this->setName('license:set');
        $this->setDescription('Set license key');
        $this->addOption('licenseKey', null, InputOption::VALUE_REQUIRED, 'License key');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $licenseKey = trim($input->getOption('licenseKey'));

        try {
            $key = new LicenseKey();
            $key->set($licenseKey);
        } catch (\Exception $ex) {
            $output->writeln("");
            throw $ex;
        }

        $this->writeSuccessMessage($output, array("Successfully set license key"));
    }
}
