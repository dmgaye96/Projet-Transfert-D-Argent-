<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UtilisateurControllerTest extends WebTestCase
{
   public function testNew()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmg',
            'PHP_AUTH_PW'=>'123'
        ] 

        );
        $client->request('POST', '/api/user/newadmin',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "raisonsociale":"Sonatel",
            "ninea":"0857gA1A",
            "adresse":"Colobane",
            "login":"d7666r8",
            "password":"123",
            "nom":"Doudou Mohamet GAYE",
            "email":"edmgaye@gmail.com",
            "telephone":782257053,
            "image_name":"https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg"
            }'
            
    );
    $a=$client->getResponse();
    var_dump($a);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    }

    public function testNewadmin()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'fall',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/user/newuser',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "login":"ad57ggg1t",
            "password":"123",
            "nom":122,
            "email":"fatout@gmail.com",
            "telephone":785056,
            "statut":"actif",
            "Partenaire":40,
            "image_name":"https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg"
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 

    public function testLogin()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmg',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/login_check',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "username":"dmg",
            "password":"123"
            
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(200,$client->getResponse()->getStatusCode());
    } 

    public function testLoginKO()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'admin150xx',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/login_check',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "username":"makber",
            "password":"123p"
            
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(401,$client->getResponse()->getStatusCode());
    } 

    public function testRegister()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmg',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/register',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "login":"ad88P77766t",
            "password":"123",
            "nom":122,
            "email":"fatout@gmail.com",
            "telephone":785056,
            "statut":"actif",
            "image_name":"https://pbs.twimg.com/media/DzuvaRsWwAIxSko.jpg"
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 


}
