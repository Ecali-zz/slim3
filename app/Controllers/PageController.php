<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Util\Variables;
use Psr\Http\Message\ServerRequestInterface;

class PageController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function test(RequestInterface $request, ResponseInterface $response)
    {
        $this->container->view->render($response, 'pages/home.twig');
    }

    public function home(RequestInterface $request, ResponseInterface $response)
    {
        $variables = new Variables();
        $variables->addInjection('PageTitle', 'Home');

        $this->container->view->render($response, 'pages/home.twig', $variables->getInjections());
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $variables = new Variables();
        $variables->addInjection('PageTitle', 'Login');

        $this->container->view->render($response, 'pages/login.twig', $variables->getInjections());
    }

    public function homeback(RequestInterface $request, ResponseInterface $response)
    {
        $variables = new Variables();

        $data = $request->getParsedBody();

        $posts = $this->container->db->query('SELECT * FROM users');

        for($y=0;$y<count($posts);$y++) {
            if ($posts[$y]['user'] === $data['Userlog'] && $posts[$y]['psw'] === $data['psw']) {
                $variables->addInjection('ErrorMsg', true);
                $variables->addInjection('lv', $posts[$y]['lva']);
            }
        }

        $variables->addInjection('user', $data['Userlog']);
        $variables->addInjection('psw', $data['psw']);
        $variables->addInjection('PageTitle', 'Homepage Backend');

        $this->container->view->render($response, 'pages/homeback.twig', $variables->getInjections());
    }
}