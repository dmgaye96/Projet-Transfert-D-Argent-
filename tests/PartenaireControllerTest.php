<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartenaireControllerTest extends WebTestCase
{

     public function testAjoutPartenaire()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmg',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/partenaire/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                "raisonsociale":"mak-secrvjice",
                "ninea":"005493j0Y",
                "adresse":"rufisqjue"

            }');
        $rep=$client->getResponse();
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }

    public function testAjoutCompte()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmg',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/compte/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                   
                    "partenaire":30
                    
            }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }


    public function testAjoutDepot()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'dmgcaisier',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/depot/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                "montant":7501000,
                "compte":1
                    
            }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
     
 }
 