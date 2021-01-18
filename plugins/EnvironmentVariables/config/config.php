<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

class NonWritingConfig extends Piwik\Config
{
    public function __construct(Piwik\Config $original)
    {
        $this->settings = $original->settings;
    }

    /**
     * Dump config
     *
     * @return string|null
     * @throws \Exception
     */
    public function dumpConfig()
    {
        return false;
    }
}

return array(
    'Piwik\Config' => DI\decorate(function ($previous, \Interop\Container\ContainerInterface $c) {
        $wrapped = new NonWritingConfig($previous);

        $settings = $c->get(\Piwik\Application\Kernel\GlobalSettingsProvider::class);

        $ini = $settings->getIniFileChain();
        $all = $ini->getAll();
        foreach ($all as $category => $settings) {
            $categoryEnvName = 'MATOMO_' . strtoupper($category);
            foreach ($settings as $settingName => $value) {
                $settingEnvName  = $categoryEnvName . '_' .strtoupper($settingName);

                $envValue = getenv($settingEnvName);
                if ($envValue !== false) {
                    $general = $wrapped->$category;
                    $general[$settingName] = $envValue;
                    $wrapped->$category = $general;
                }
            }
        }

        return $wrapped;
    }),
);
