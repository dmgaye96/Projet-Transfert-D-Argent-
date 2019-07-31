<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UtilisateurControllerTest extends WebTestCase
{
   public function testNew()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'mak',
            'PHP_AUTH_PW'=>'123'
        ] 

        );
        $client->request('POST', '/api/user/newadmin',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "login":"adm90pyt",
            "password":"123",
            "nom":"maman fatou",
            "email":"fatout@gmail.com",
            "telephone":785056,
            "statut":"actif",
            "Partenaire":1
            }'
            
    );
    $a=$client->getResponse();
    var_dump($a);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    }

    public function testNewadmin()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'admin1',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/user/newuser',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "login":"adPzq71t",
            "password":"123",
            "nom":122,
            "email":"fatout@gmail.com",
            "telephone":785056,
            "statut":"actif",
            "Partenaire":"1"
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 
    public function testLogin()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'admin1',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/login_check',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "username":"mak",
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
            'PHP_AUTH_USER'=>'admin1',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/login_check',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "username":"makb",
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
            'PHP_AUTH_USER'=>'mak',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $client->request('POST', '/api/register',[],[],
        ['CONTENT_TYPE'=>"application/json"],
        '{
            "login":"adPx71t",
            "password":"123",
            "nom":122,
            "email":"fatout@gmail.com",
            "telephone":785056,
            "statut":"actif",
            "Partenaire":"1"
            }'
    );
  $re =$client->getResponse();
    var_dump($re);
    $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 


}
