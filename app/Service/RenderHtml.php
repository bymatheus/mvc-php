<?php

namespace MVC\Service;

trait RenderHtml
{
    public function render(string $pathTemplate, array $data)
    {
        extract($data);
        ob_start();
        $pathViews = __DIR__ . '/../../resources/views/';
        require $pathViews . 'head.php';
        require $pathViews . 'navbar.php';
        require $pathViews.$pathTemplate.'.php';
        require $pathViews . 'footer.php';
        return ob_get_clean();
    }
}
