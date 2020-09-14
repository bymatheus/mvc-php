<?php

namespace MVC\Controllers;

use MVC\Service\RenderHtml;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Index implements RequestHandlerInterface
{
    use RenderHtml;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(
            200,
            [],
            $this->render('index/index', [
                'titulo' => 'Titulo',
                'descricao' => 'Descrição',
                'robots' => 'Index, Follow'
            ])
        );
    }
}
