<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Console\Kernel;

use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

class UsersQueryTest extends TestCase
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

    public function testUsersQuery(): void
    {
        $query = $this->query(
            new Query(
                'users',
                [],
                [
                    'id',
                    'name',
                    'email',
                    'password'
                ]
            )
        );

        // Esto muestra la query que se está creando...
        echo json_encode($query);

        $actual = json_encode($query);
        $expectedUserNull = json_encode(["users" => null]);
        $expectedErrors = json_encode("errors");


        if(Str::contains($actual, $expectedUserNull))
        {
            $this->assertTrue(false, "Los usuarios no se han mostrado (UsersQuery Failed), usuarios null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            $this->assertTrue(false, "Los usuarios no se han mostrado (UsersQuery Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "Los usuarios se han mostrado correctamente");
        }
    }
}
