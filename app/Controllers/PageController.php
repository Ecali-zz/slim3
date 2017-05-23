<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Util\Variables;
use Psr\Http\Message\ServerRequestInterface;

class PageController
{
    private $container;
    private $variables = [];
    public function __construct($container)
    {
        $this->container = $container;
        $this->variables = new Variables();
    }

    public function test(RequestInterface $request, ResponseInterface $response)
    {
        $this->container->view->render($response, 'pages/home.twig');
    }

    public function home(RequestInterface $request, ResponseInterface $response)
    {
        $this->variables->addInjection('PageTitle', 'Home');

        $this->container->view->render($response, 'pages/home.twig', $this->variables->getInjections());
    }

    public function login(RequestInterface $request, ResponseInterface $response)
    {
        $this->variables->addInjection('PageTitle', 'Login');

        $this->container->view->render($response, 'pages/login.twig', $this->variables->getInjections());
    }

    public function homeback(RequestInterface $request, ResponseInterface $response)
    {

        $data = $request->getParsedBody();

        $posts = $this->container->db->queryuser();
        $news = $this->container->db->querypost();
        for($y=0;$y<count($posts);$y++) {
            if ($posts[$y]['user'] === $data['Userlog'] && $posts[$y]['psw'] === $data['psw']) {
                $this->variables->addInjection('ErrorMsg', true);
                $this->variables->addInjection('lv', $posts[$y]['lva']);
            }
        }
        $_SESSION['Userlog'] = $data['Userlog'];
        $_SESSION['psw']= $data['psw'];
        //die(var_dump($_SESSION));
        $this->variables->addInjection('Userlog', $data['Userlog']);
        $this->variables->addInjection('psw', $data['psw']);
        $this->variables->addInjection('PageTitle', 'Homepage Backend');
        for($y=2;$y>=0;$y--) {
            if($news[$y]['title'] !== '') {
                $this->variables->addInjection('titlenews' . $y, $news[$y]['title']);
                $this->variables->addInjection('bodynews' . $y, $news[$y]['body']);
                $this->variables->addInjection('imgnews' . $y, $news[$y]['img']);
            }
        }
        //die(var_dump($this->variables->getInjections()));
        $this->container->view->render($response, 'pages/homeback.twig', $this->variables->getInjections());
    }
    public function addNews(RequestInterface $request, ResponseInterface $response)
    {
        $this->variables->addInjection('PageTitle', 'Add a News');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);
        $this->variables->addInjection('psw',$_SESSION['psw']);
        //die(var_dump($this->variables->getInjections()));
        $this->container->view->render($response, 'pages/addnews.twig', $this->variables->getInjections());
    }

}