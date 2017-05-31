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

            if($news[$y]['title'] !== null) {
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

            if($news[$y]['title'] !== null) {
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
    public function user(RequestInterface $request, ResponseInterface $response)
    {
        $this->variables->addInjection('PageTitle', 'User Backend');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);
        $this->variables->addInjection('video','<iframe width="560" height="315" src="https://www.youtube.com/embed/s1xbQVNGSPQ?list=PLlyrc-a-pcGiOBtu6dFFVH2sIZPzvXAdH" frameborder="0" allowfullscreen></iframe>
');
        $this->container->view->render($response, 'pages/user.twig', $this->variables->getInjections());

    }

    public function addvideo(RequestInterface $request, ResponseInterface $response)
    {
        $videoesiste=false;
        $video = $this->container->db->queryvideo();
        for ($x = 0; $x < count($video); $x++) {
            if ($video[$x]['titolovideo'] == $_GET['title']) {
                $videoesiste=true;
                $this->variables->addInjection('Errorvideoesiste', 'Il video è già stato Inserito');
            }
        }
            if ($_GET['title'] != null && $videoesiste === false) {
                $this->variables->addInjection('title', $_GET['title']);
                $title = $_GET['title'];
                $embed = $_GET['embed'];
                if ($_GET['tag'] == null) {
                    $tag = 'none';
                } else {
                    $tag = $_GET['tag'];
                }
                if ($_GET['protetto'] == null) {
                    $protetto = false;
                } else {
                    $protetto = true;
                }
                if ($_GET['playlist'] == null) {
                    $playlist = false;
                } else {
                    $playlist = true;
                }
                $this->container->db->addvideo($title, $embed, $tag, $protetto, $playlist);
                $this->variables->addInjection('okadd', true);
            }

        $this->variables->addInjection('PageTitle', 'Add video');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);

        $this->container->view->render($response, 'pages/addvideo.twig', $this->variables->getInjections());
    }
    public function viewvideo(RequestInterface $request, ResponseInterface $response)
    {
        $video = $this->container->db->queryvideo();
        //die(var_dump($video));
        for($x=0;$x<count($video);$x++){
            $this->variables->addInjection('titolo', $video[$x][1]);
            $this->variables->addInjection('playlist', $video[$x][2]);
            $this->variables->addInjection('embed', $video[$x][3]);
            $this->variables->addInjection('protetto', $video[$x][4]);
            $this->variables->addInjection('tag', $video[$x][5]);
        }
        $this->variables->addInjection('PageTitle', 'view all video');
        $this->variables->addInjection('Userlog',$_SESSION['Userlog']);

        $this->container->view->render($response, 'pages/viewallvideo.twig', $this->variables->getInjections());
    }
}