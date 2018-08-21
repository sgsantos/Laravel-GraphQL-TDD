<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

use App\GraphQL\Query\UserQuery;

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
     * Función test modelo para probar el type de un Query.
     */
    public function testType()
    {
        $userQuery = new UserQuery();
        if($userQuery->type() != 'UserType')
        {
            $this->assertTrue(false, "El tipo debe ser UserType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es UserType.");
        }
    }

    /**
     * Función test modelo para probar la cantidad de argumentos de un Query.
     */
    public function testQuantityArgs()
    {
        $userQuery = new UserQuery();

        if(sizeof($userQuery->args()) == 0)
        {
            $this->assertTrue(false, "Esta Query espera parámetros (args required), FAILED.");
        }
        else
        {
            $this->assertTrue(true, "La cantidad de parámetros es la adecuada.");
        }
    }

    /**
     * Función test modelo para probar el argumento id de un Query.
     */
    public function testIdArgs()
    {
        $userQuery = new UserQuery();

        if (!isset($userQuery->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($userQuery->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($userQuery->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($userQuery->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($userQuery->args()['id']['type'] != 'Int!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo entero no nulo [type required: int() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
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

        $actual = json_encode($query);
        $expectedUserNull = json_encode(["user" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedUserNull))
        {
            // Esto muestra el Query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "El usuario no se ha mostrado (UserQuery Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra el Query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "El usuario no se ha mostrado (UserQuery Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha mostrado correctamente");
        }


    }
}
