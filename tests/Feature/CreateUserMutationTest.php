<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;

use App\GraphQL\Mutation\CreateUserMutation;

class CreateUserMutationTest extends TestCase
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
        $createUserMutation = new CreateUserMutation();
        if($createUserMutation->type() != 'UserType')
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
        $createUserMutation = new CreateUserMutation();

        if(sizeof($createUserMutation->args()) == 0)
        {
            $this->assertTrue(false, "Esta Mutation espera parámetros (args required), FAILED.");
        }
        else
        {
            $this->assertTrue(true, "La cantidad de parámetros es la adecuada.");
        }
    }

    /**
     * Función test modelo para probar el argumento name de una Mutation.
     */
    public function testNameArgs()
    {
        $createUserMutation = new CreateUserMutation();

        if (!isset($createUserMutation->args()['name']))
        {
            $this->assertTrue(false, "El parámetro name no existe [name required], FAILED.");
        }
        elseif (json_encode($createUserMutation->args()['name']) == '[]')
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['name']['description']))
        {
            $this->assertTrue(false, "El parámetro name necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['name']['type']))
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo [type required], FAILED.");
        }
        elseif($createUserMutation->args()['name']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro name necesita un tipo string no nulo [type required: string() nonnull], FAILED.");
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
        $createUserMutation = new CreateUserMutation();

        if (!isset($createUserMutation->args()['email']))
        {
            $this->assertTrue(false, "El parámetro email no existe [email required], FAILED.");
        }
        elseif (json_encode($createUserMutation->args()['email']) == '[]')
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo, una descripción y reglas [type, description and rules required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['email']['description']))
        {
            $this->assertTrue(false, "El parámetro email necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['email']['type']))
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo [type required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['email']['rules']))
        {
            $this->assertTrue(false, "El parámetro email necesita reglas [rules required], FAILED.");
        }
        elseif($createUserMutation->args()['email']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro email necesita un tipo string no nulo [type required: string() nonnull], FAILED.");
        }
        elseif($createUserMutation->args()['email']['rules'] != ['email', 'unique:users'])
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
        $createUserMutation = new CreateUserMutation();

        if (!isset($createUserMutation->args()['password']))
        {
            $this->assertTrue(false, "El parámetro password no existe [password required], FAILED.");
        }
        elseif (json_encode($createUserMutation->args()['password']) == '[]')
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo, una descripción y reglas [type, description and rules required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['password']['description']))
        {
            $this->assertTrue(false, "El parámetro password necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['password']['type']))
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo [type required], FAILED.");
        }
        elseif(!isset($createUserMutation->args()['password']['rules']))
        {
            $this->assertTrue(false, "El parámetro password necesita reglas [rules required], FAILED.");
        }
        elseif($createUserMutation->args()['password']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro password necesita un tipo string no nulo [type required: string() nonnull], FAILED.");
        }
        elseif($createUserMutation->args()['password']['rules'] != ['min:4'])
        {
            $this->assertTrue(false, "El parámetro rules necesita que el campo password contenga un mínimo de 4 caracteres [required: min:4], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    // testing resolve
    public function testCreateUserMutation():void
    {

        $faker = Faker::create();

        $mutation = $this->mutation(
            new Mutation(
                'createUser',
                [
                    'name' => $faker->name(),
                    'email' => $faker->unique()->email(),
                    'password' => $faker->password($minLength = 4, $maxLength = 10)
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
        $expectedUserNull = json_encode(["createPost" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedUserNull))
        {
            // Esto muestra la mutación que se está creando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha creado (CreateUserMutation Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la mutación que se está creando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El usuario no se ha creado (CreateUserMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha creado correctamente");
        }


    }


}
