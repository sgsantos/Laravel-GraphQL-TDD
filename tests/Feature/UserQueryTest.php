<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Console\Kernel;

use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

class UserQueryTest extends TestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // Hay que buscar como poner el camino dinámicamente....

        $app = require '/var/www/html/APIgraphQL/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    protected function setUp()
    {
        $this->setDefaultHeaders([
            'Content-Type' => 'application/json',
        ]);
    }

    public function testUserQuery(): void
    {
        $query = $this->query(
            new Query(
                'user',
                [
                    'id' => 1
                ],
                [
                    'id',
                    'name',
                    'email',
                    'password'
                ]
            )
        );

        // Esto muestra la mutación que se está creando...
        echo json_encode($query);

        $actual = json_encode($query);
        $expectedUserNull = json_encode(["user" => null]);
        $expectedErrors = json_encode("errors");


        if(Str::contains($actual, $expectedUserNull))
        {
            $this->assertTrue(false, "El usuario no se ha mostrado (UserQuery Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            $this->assertTrue(false, "El usuario no se ha mostrado (UserQuery Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha mostrado correctamente");
        }


    }
}
