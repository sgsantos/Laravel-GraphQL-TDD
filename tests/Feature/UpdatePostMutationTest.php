<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Mutation;

use App\GraphQL\Mutation\UpdatePostMutation;

class UpdatePostMutationTest extends TestCase
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
        $updatePostMutation = new UpdatePostMutation();

        if($updatePostMutation->type() != 'PostType')
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
        $updatePostMutation = new UpdatePostMutation();

        if(sizeof($updatePostMutation->args()) == 0)
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
        $updatePostMutation = new UpdatePostMutation();

        if (!isset($updatePostMutation->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($updatePostMutation->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($updatePostMutation->args()['id']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo string no nulo [type required: string() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento user_id de una Mutation.
     */
    public function testIdUserArgs()
    {
        $updatePostMutation = new UpdatePostMutation();

        if (!isset($updatePostMutation->args()['user_id']))
        {
            $this->assertTrue(false, "El parámetro user_id no existe [user_id required], FAILED.");
        }
        elseif (json_encode($updatePostMutation->args()['user_id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro user_id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['user_id']['description']))
        {
            $this->assertTrue(false, "El parámetro user_id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['user_id']['type']))
        {
            $this->assertTrue(false, "El parámetro user_id necesita un tipo [type required], FAILED.");
        }
        elseif($updatePostMutation->args()['user_id']['type'] != 'String!' && $updatePostMutation->args()['user_id']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro user_id necesita un tipo string [type required: string()], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento title de una Mutation.
     */
    public function testTitleArgs()
    {
        $updatePostMutation = new UpdatePostMutation();

        if (!isset($updatePostMutation->args()['title']))
        {
            $this->assertTrue(false, "El parámetro title no existe [title required], FAILED.");
        }
        elseif (json_encode($updatePostMutation->args()['title']) == '[]')
        {
            $this->assertTrue(false, "El parámetro title necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['title']['description']))
        {
            $this->assertTrue(false, "El parámetro title necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['title']['type']))
        {
            $this->assertTrue(false, "El parámetro title necesita un tipo [type required], FAILED.");
        }
        elseif($updatePostMutation->args()['title']['type'] != 'String!' && $updatePostMutation->args()['title']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro title necesita un tipo string no nulo [type required: string() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el argumento body de una Mutation.
     */
    public function testBodyArgs()
    {
        $updatePostMutation = new UpdatePostMutation();

        if (!isset($updatePostMutation->args()['body']))
        {
            $this->assertTrue(false, "El parámetro body no existe [body required], FAILED.");
        }
        elseif (json_encode($updatePostMutation->args()['body']) == '[]')
        {
            $this->assertTrue(false, "El parámetro body necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['body']['description']))
        {
            $this->assertTrue(false, "El parámetro body necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($updatePostMutation->args()['body']['type']))
        {
            $this->assertTrue(false, "El parámetro body necesita un tipo [type required], FAILED.");
        }
        elseif($updatePostMutation->args()['body']['type'] != 'String')
        {
            $this->assertTrue(false, "El parámetro body necesita un tipo string que pueda tomar valores nulos [type required: string()], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }

    /**
     * Función test modelo para probar el resultado de una Mutation.
     */
    public function testUpdatePostMutation(): void
    {
        $faker = Faker::create();

        $mutation = $this->mutation(
            new Mutation(
                'updatePost',
                [
                    'id' => "5b7dabbbd686a57bb2307912", //$faker->numberBetween(1,50),
                    'user_id' => "5b7daba7d686a573a92f2372",
                    'title' => $faker->sentence(),
                    'body' => $faker->text()
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
        $expectedPostNull = json_encode(["updatePost" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedPostNull))
        {
            // Esto muestra la mutación que se está actualizando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El Post no se ha actualizado (UpdatePostMutation Failed), post null");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la mutación que se está actualizando...
            echo json_encode($mutation);
            $this->assertTrue(false, "El post no se ha actualizado (UpdatePostMutation Failed), existen errores en los datos");
        }
        else{
            $this->assertTrue(true, "El post se ha actualizado correctamente");
        }
    }
    
}
