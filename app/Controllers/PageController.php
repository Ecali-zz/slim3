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
    private $dest = '/Users/elvio/Sites/Slim3/public/images';
    private $src= '/Users/elvio/Desktop/upimg';
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
        $this->variables->addInjection('Userlog', $data['Userlog']);
        $this->variables->addInjection('psw', $data['psw']);
        $this->variables->addInjection('PageTitle', 'Homepage Backend');
        $count=count($news)-1;
        $count=$count-3;
        $h=0;
        for($y=$count+3;$y>=$count;$y--) {

            if($news[$y]['title'] !== '') {
                $img='/images/'.$news[$y]['img'];
                $this->variables->addInjection('titlenews' . $h, $news[$y]['title']);
                $this->variables->addInjection('bodynews' . $h, $news[$y]['body']);
                $this->variables->addInjection('imgnews' . $h, $img);
            }
            $h+=1;
        }
        //die(var_dump($this->variables->getInjections()));
        $this->container->view->render($response, 'pages/homeback.twig', $this->variables->getInjections());
    }
    public function addNews(RequestInterface $request, ResponseInterface $response)
    {
        $title = $_GET['title'];
        if($title !== null) {

            $body = $_GET['body'];
            $img = $_GET['userfile'];

            $desttemp=$this->dest;
            $srctemp=$this->src;
            $srctemp .= '/'.$img;
            $desttemp .= '/'.$img;
            copy($srctemp, $desttemp);

            $this->variables->addInjection('titlenews', $title);
            $this->variables->addInjection('okadd',true );
            $this->container->db->addpost ($title, $body, $img);
        }
        $this->variables->addInjection('PageTitle', 'Add a News');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);
        $this->variables->addInjection('psw',$_SESSION['psw']);
        $this->container->view->render($response, 'pages/addnews.twig', $this->variables->getInjections());
    }
    public function gethomeback(RequestInterface $request, ResponseInterface $response)
    {
        $news = $this->container->db->querypost();
        $this->variables->addInjection('PageTitle', 'Homepage Backend');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);
        $count=count($news)-1;
        $count=$count-3;
        $h=0;
        for($y=$count+3;$y>=$count;$y--) {

            if($news[$y]['title'] !== '') {
                $img='/images/'.$news[$y]['img'];
                $this->variables->addInjection('titlenews' . $h, $news[$y]['title']);
                $this->variables->addInjection('bodynews' . $h, $news[$y]['body']);
                $this->variables->addInjection('imgnews' . $h, $img);
            }
            $h+=1;
        }
        $this->variables->addInjection('ErrorMsg', true);
        $this->container->view->render($response, 'pages/homeback.twig', $this->variables->getInjections());

    }
}