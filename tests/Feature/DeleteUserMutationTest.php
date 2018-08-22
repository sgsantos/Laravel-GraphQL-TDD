<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;

use App\GraphQL\Mutation\DeleteUserMutation;

class DeleteUserMutationTest extends TestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        //TODO: Hay que buscar como poner el camino dinámicamente....

        $app = require '/var/www/html/APIgraphQL/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Función test modelo para probar el type de un Mutation.
     */
    public function testType()
    {
        $deleteUserMutation = new DeleteUserMutation();
        if($deleteUserMutation->type() != 'UserType')
        {
            $this->assertTrue(false, "El tipo debe ser UserType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es UserType.");
        }
    }

    /**
     * Función test modelo para probar la cantidad de argumentos de una Mutation.
     */
    public function testQuantityArgs()
    {
        $deleteUserMutation = new DeleteUserMutation();

        if(sizeof($deleteUserMutation->args()) == 0)
        {
            $this->assertTrue(false, "Esta Mutation espera parámetros (args required), FAILED.");
        }
        else
        {
            $this->assertTrue(true, "La cantidad de parámetros es la adecuada.");
        }
    }

    /**
     * Función test modelo para probar el argumento id de una Mutation.
     */
    public function testIdUserArgs()
    {
        $deleteUserMutation = new DeleteUserMutation();

        if (!isset($deleteUserMutation->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($deleteUserMutation->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($deleteUserMutation->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($deleteUserMutation->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($deleteUserMutation->args()['id']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo entero no nulo [type required: string() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }


    public function testDeleteUserMutation():void
    {
        $faker = Faker::create();

        $mutation = $this->mutation(
            new Mutation(
                'deleteUser',
                [
                    'id' => "5b7dafbbd686a57ef14e1d43"
                ],
                [
                    'id',
                    'name',
                    'email',
                    'password'
                ]
            )
        );

        $actual = json_encode($mutation);
        $expectedUserNull = json_encode(["deleteUser" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedUserNull))
        {
            // Esto muestra la mutación que se está eliminando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha eliminado (DeleteUserMutation Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la mutación que se está eliminando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha eliminado (DeleteUserMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha eliminado correctamente");
        }


    }

}
