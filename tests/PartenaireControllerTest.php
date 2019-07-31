<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartenaireControllerTest extends WebTestCase
{

     public function testAjoutPartenaire()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'mak',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/partenaire/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                "raisonsociale":"mak-service",
                "ninea":"0054930Y",
                "adresse":"rufisque"

            }');
        $rep=$client->getResponse();
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }

    public function testAjoutCompte()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'mak',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/compte/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                    "numerocompte":1148,
                    "solde":0,
                    "partenaire":5
                    
            }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }


    public function testAjoutDepot()
    {
        $client = static::createClient([],[
            'PHP_AUTH_USER'=>'mak',
            'PHP_AUTH_PW'=>'123'
        ]

        );
        $crawler = $client->request('POST', '/api/depot/new',[],[],
        ['CONTENT_TYPE'=>"application/json"],'

            {
                "montant":30000,
                "compte":1
                    
            }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    }
     
 }
 