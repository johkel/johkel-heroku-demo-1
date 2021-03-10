<?php
/**
 * Klass för att hantera logiken med View
 * @author Johan
 */

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{

    public function __construct(string $twigFile, array $data)
    {
        $loader = new FilesystemLoader('../app/views');
        $twig = new Environment($loader, []);
        try {
            $template = $twig->load($twigFile);
            echo $template->render($data);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            var_dump($e);
        }
    }

    public static function render(string $twigFile, array $data)
    {
        new View($twigFile, $data);
    }
}
