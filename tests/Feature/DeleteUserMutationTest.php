<?php

namespace Tests\Feature;

use App\GraphQL\Mutation\DeleteUserMutation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Contracts\Console\Kernel;

use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;
use App\User;

class DeleteUserMutationTest extends TestCase
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

    public function testDeleteUserMutation():void
    {
//        $this->mutation(
//            new Mutation(
//                'createUser',
//                [
//                    'name' => 'NombrePrueba',
//                    'email' => 'correoprueba@uci.cu',
//                    'password' => '123456789'
//                ],
//                [
//                    'name',
//                    'email'
//                ]
//            )
//        );


        $mutation = $this->mutation(
            new Mutation(
                'deleteUser',
                [
                    'id' => 34// Hay que pasar un id automático
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
        $expectedUserNull = json_encode(["deleteUser" => null]);
        $expectedErrors = json_encode("errors");


        if(Str::contains($actual, $expectedUserNull))
        {
            $this->assertTrue(false, "El usuario no se ha eliminado (DeleteUserMutation Failed), usuario null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            $this->assertTrue(false, "El usuario no se ha eliminado (DeleteUserMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El usuario se ha eliminado correctamente");
        }


    }

}
