<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SmsSendTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->call('post', '/api/sms/send', [
            'mobiles' => '13581568973',
            'content' => '内容内容..............................',
            'opertion_time' => date('Y-m-d H:i:s')
        ]);

        echo $response->content();
        $this->assertEquals(200, $response->status());
    }
}
