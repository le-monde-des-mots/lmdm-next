<?php
declare(strict_types=1);

namespace LmdmNext\Application\Settings;

use LmdmNext\Application\Settings\SettingsInterface;

class Settings implements SettingsInterface
{
    private array $_settings;

    public function __construct(array $settings) {
        $this->_settings = $settings;
    }

    public function get(string $key = ''): mixed
    {
        return (empty($key)) ? $this->_settings : $this->_settings[$key];
    }
}