<?php


namespace App\Core;


use Twig\Loader\LoaderInterface;

class Tpl extends \Twig\Environment
{
    public function __construct(string $tplPath = '', $options = [])
    {
        $tplPath = $tplPath ?: Core::Config()->get('tpl.twig.tpl_path');
        $cachePath = $options['cache'] ?? Core::Config()->get('tpl.twig.cache_path');
        $autoReload = $options['auto_reload'] ?? Core::Config()->get('tpl.twig.auto_reload');

        $loader = new \Twig\Loader\FilesystemLoader($tplPath);
        parent::__construct($loader, [
            'cache' => $cachePath,
            'auto_reload' => $autoReload,
        ]);
    }
}