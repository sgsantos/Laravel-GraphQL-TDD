<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;

use App\GraphQL\Mutation\DeletePostMutation;

class DeletePostMutationTest extends TestCase
{
    /** Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require '/var/www/html/APIgraphQL/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

    /**
     * Función test modelo para probar el type de un Mutation.
     */
    public function testType()
    {
        $deletePostMutation = new DeletePostMutation();
        if($deletePostMutation->type() != 'PostType')
        {
            $this->assertTrue(false, "El tipo debe ser PostType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es PostType.");
        }
    }


    /**
     * Función test modelo para probar la cantidad de argumentos de una Mutation.
     */
    public function testQuantityArgs()
    {
        $deletePostMutation = new DeletePostMutation();

        if(sizeof($deletePostMutation->args()) == 0)
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
    public function testIdPostArgs()
    {
        $deletePostMutation = new DeletePostMutation();

        if (!isset($deletePostMutation->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($deletePostMutation->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($deletePostMutation->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($deletePostMutation->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($deletePostMutation->args()['id']['type'] != 'Int!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo entero no nulo [type required: int() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el resultado de una Mutation.
     */
    public function testDeletePostMutation(): void
    {
        $faker = Faker::create();

        $mutation = $this->mutation(
            new Mutation(
                'deletePost',
                [
                    'id' => 4 //$faker->numberBetween(0,50),
                ],
                [
                    'id',
                    'user_id',
                    'title',
                    'body'
                ]
            )
        );

        $actual = json_encode($mutation);
        $expectedPostNull = json_encode(["deletePost" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedPostNull))
        {
            $this->assertTrue(false, "El Post no se ha eliminado (DeletePostMutation Failed), post null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            $this->assertTrue(false, "El post no se ha eliminado (DeletePostMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El post se ha eliminado correctamente");
        }
    }
    
}
