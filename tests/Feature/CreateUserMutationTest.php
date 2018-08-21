<?php

namespace Tests\Feature;

use App\GraphQL\Mutation\CreateUserMutation;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Contracts\Console\Kernel;

use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;
use App\User;
use Faker\Factory as Faker;
class CreateUserMutationTest extends TestCase
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

    protected function setUp()
    {
        $this->setDefaultHeaders([
            'Content-Type' => 'application/json',
        ]);
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



        // Esto muestra la mutación que se está creando...
        echo json_encode($mutation);

        $actual = json_encode($mutation);
        $expectedUserNull = json_encode(["createPost" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedUserNull))
        {
            $this->assertTrue(false, "El usuario no se ha creado (CreateUserMutation Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            $this->assertTrue(false, "El usuario no se ha creado (CreateUserMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha creado correctamente");
        }


    }


}
