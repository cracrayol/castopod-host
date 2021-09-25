<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Honeypot extends BaseConfig
{
    /**
     * Makes Honeypot visible or not to human
     */
    public $hidden = true;

    /**
     * Honeypot Label Content
     */
    public $label = 'Fill This Field';

    /**
     * Honeypot Field Name
     */
    public $name = 'honeypot';

    /**
     * Honeypot HTML Template
     */
    public $template = '<label>{label}</label><input type="text" name="{name}" value=""/>';

    /**
     * Honeypot container
     */
    public $container = '<div style="display:none">{template}</div>';
}
