<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

use App\GraphQL\Query\UsersQuery;

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
     * Función test modelo para probar el type de un Query.
     */
    public function testType()
    {
        $usersQuery = new UsersQuery();
        if($usersQuery->type() != '[UserType]')
        {
            $this->assertTrue(false, "El tipo debe ser una lista de UserType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es una lista de UserType.");
        }

    }

    /**
     * Función test modelo para probar los argumentos de un Query.
     */
    public function testArgs()
    {
        $usersQuery = new UsersQuery();

        if(sizeof($usersQuery->args()) > 0)
        {
            $this->assertTrue(false, "Esta Query no espera parámetros, FAILED.");
        }
        else
        {
            $this->assertTrue(true, "Se ejecutó correctamente");
        }
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

        $actual = json_encode($query);
        $expectedUserNull = json_encode(["users" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedUserNull))
        {
            // Esto muestra la query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "Los usuarios no se han mostrado (UsersQuery Failed), usuarios null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "Los usuarios no se han mostrado (UsersQuery Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "Los usuarios se han mostrado correctamente");
        }
    }
}
