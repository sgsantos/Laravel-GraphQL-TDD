<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;

use App\GraphQL\Mutation\UpdateUserMutation;
use App\User;

class UpdateUserMutationTest extends TestCase
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
        $updateUserMutation = new UpdateUserMutation();

        if($updateUserMutation->type() != 'UserType')
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
        $updateUserMutation = new UpdateUserMutation();

        if(sizeof($updateUserMutation->args()) == 0)
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
        $updateUserMutation = new UpdateUserMutation();

        if (!isset($updateUserMutation->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($updateUserMutation->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($updateUserMutation->args()['id']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo entero no nulo [type required: string() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento name de una Mutation.
     */
    public function testNameArgs()
    {
        $updateUserMutation = new UpdateUserMutation();

        if (!isset($updateUserMutation->args()['name']))
        {
            $this->assertTrue(false, "El parámetro name no existe [name required], FAILED.");
        }
        elseif (json_encode($updateUserMutation->args()['name']) == '[]')
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['name']['description']))
        {
            $this->assertTrue(false, "El parámetro name necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['name']['type']))
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo [type required], FAILED.");
        }
        elseif($updateUserMutation->args()['name']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo string [type required: string()], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento email de una Mutation.
     */
    public function testEmailArgs()
    {
        $updateUserMutation = new UpdateUserMutation();

        if (!isset($updateUserMutation->args()['email']))
        {
            $this->assertTrue(false, "El parámetro email no existe [email required], FAILED.");
        }
        elseif (json_encode($updateUserMutation->args()['email']) == '[]')
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo, una descripción y reglas [type, description and rules required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['email']['description']))
        {
            $this->assertTrue(false, "El parámetro email necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['email']['type']))
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo [type required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['email']['rules']))
        {
            $this->assertTrue(false, "El parámetro email necesita reglas [rules required], FAILED.");
        }
        elseif($updateUserMutation->args()['email']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo string [type required: string()], FAILED.");
        }
        elseif($updateUserMutation->args()['email']['rules'] != ['email', 'unique:users'])
        {
            $this->assertTrue(false, "El parámetro rules necesita hacer que el correo sea único por usuario [required: unique:users], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento password de una Mutation.
     */
    public function testPasswordArgs()
    {
        $updateUserMutation = new UpdateUserMutation();

        if (!isset($updateUserMutation->args()['password']))
        {
            $this->assertTrue(false, "El parámetro password no existe [password required], FAILED.");
        }
        elseif (json_encode($updateUserMutation->args()['password']) == '[]')
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo, una descripción y reglas [type, description and rules required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['password']['description']))
        {
            $this->assertTrue(false, "El parámetro password necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['password']['type']))
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo [type required], FAILED.");
        }
        elseif(!isset($updateUserMutation->args()['password']['rules']))
        {
            $this->assertTrue(false, "El parámetro password necesita reglas [rules required], FAILED.");
        }
        elseif($updateUserMutation->args()['password']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo string [type required: string()], FAILED.");
        }
        elseif($updateUserMutation->args()['password']['rules'] != ['min:4'])
        {
            $this->assertTrue(false, "El parámetro rules necesita que el campo password contenga un mínimo de 4 caracteres [required: min:4], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }


    public function testUptadeUserMutation(): void
    {
        $faker = Faker::create();
        $id_prueba = "1";

        $mutation = $this->mutation(
            new Mutation(
                'updateUser',
                [
                    'id' => $id_prueba,
                    'name' => $faker->name(),
                    'email' => $faker->unique()->email(),
                    'password' => $faker->password()
                ],
                [
                    'id',
                    'name',
                    'email',
                    'password'
                ]
            )
        );

        if(!User::find($id_prueba)){
            $this->assertTrue(false, "El usuario con el id propuesto por la función de prueba no existe en la base de datos; cambie el id en la función de prueba.");
        }


        // Esto muestra la mutación que se está creando...
        echo json_encode($mutation);

        $actual = json_encode($mutation);
        $expectedUserNull = json_encode(["updateUser" => null]);
        $expectedErrors = json_encode("errors");


        if(Str::contains($actual, $expectedUserNull))
        {
            // Esto muestra la mutación que se está actualizando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha actualizado (UpdateUserMutation Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la mutación que se está actualizando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha actualizado (UpdateUserMutation Failed), existen errores en los datos");
        }
        else
        {
            $this->assertTrue(true, "El usuario se ha actualizado correctamente");
        }


    }
}
