<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PageController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function test(RequestInterface $request, ResponseInterface $response)
    {
        //die(var_dump(get_declared_classes()));

        $this->container->view->render($response, 'pages/home.twig');
    }

    public function home(RequestInterface $request, ResponseInterface $response)
    {
        $txt= new TextPageControll();
        $txt = $txt->text;
        $txt['PageTitle'] = 'Home';
        $this->container->view->render($response, 'pages/home.twig', $txt);
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $txt= new TextPageControll();
        $txt = $txt->text;
        $txt['PageTitle'] = 'Login';

        $this->container->view->render($response, 'pages/login.twig', $txt);
    }
    public function homeback(RequestInterface $request, ResponseInterface $response)
    {
        $txt = new TextPageControll();
        $txt = $txt->text;
        $data = $request->getParsedBody();

        $posts = $this->container->db->query('SELECT * FROM post');
        die(var_dump($posts));

        $txt['user'] = $data['Userlog'];
        $txt['psw'] = $data['psw'];

        $txt['PageTitle'] = 'Homepage Backend';

        $this->container->view->render($response, 'pages/homeback.twig', $txt);
    }
}