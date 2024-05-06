<?php

namespace Services;

use Components\TemplateNotFoundException;

class TemplateService
{
    private static ?TemplateService $templateObj = null;

    private string $path;
    private array $data;

    public function __construct()
    {

    }

    public static function getInstance(): object
    {
        if (self::$templateObj === null) {
            self::$templateObj = new TemplateService();
        }

        return self::$templateObj;
    }

    /**
     * @throws TemplateNotFoundException
     */
    public function render(string $template, array $data): ?string
    {
        $this->path = $this->createPath($template);
        $this->data = $data;
        ob_start();

        (function () {
            extract($this->data);
            include $this->path;
        })();

        return ob_get_clean();
    }

    /**
     * @throws TemplateNotFoundException
     */
    private function createPath(string $template): string
    {
        $path = __DIR__ . '/../Resources/' . str_replace('.', DIRECTORY_SEPARATOR, $template) . '.php';

        if (!file_exists($path)) {
            throw TemplateNotFoundException::make($template);
        } else {
            return $path;
        }
    }

}