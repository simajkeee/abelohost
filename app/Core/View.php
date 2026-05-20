<?php

declare(strict_types=1);

namespace Abelohost\TestApp\Core;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;
    public function __construct()
    {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(APP_ROOT . '/templates');
        $this->smarty->setCompileDir(APP_ROOT . '/storage/smarty/compile');
        $this->smarty->setCacheDir(APP_ROOT . '/storage/smarty/cache');
    }

    public function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}

