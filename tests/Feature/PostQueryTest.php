<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

use App\GraphQL\Query\PostQuery;
use App\Post;

class PostQueryTest extends TestCase
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
     * Función test modelo para probar el type de un Query.
     */
    public function testType()
    {
        $postQuery = new PostQuery();
        if($postQuery->type() != 'PostType')
        {
            $this->assertTrue(false, "El tipo debe ser PostType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es PostType.");
        }
    }

    /**
     * Función test modelo para probar la cantidad de argumentos de un Query.
     */
    public function testQuantityArgs()
    {
        $PostQuery = new PostQuery();

        if(sizeof($PostQuery->args()) == 0)
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
        $postQuery = new PostQuery();

        if (!isset($postQuery->args()['id']))
        {
            $this->assertTrue(false, "El parámetro id no existe [id required], FAILED.");
        }
        elseif (json_encode($postQuery->args()['id']) == '[]')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo y una descripción [type and description required], FAILED.");
        }
        elseif(!isset($postQuery->args()['id']['description']))
        {
            $this->assertTrue(false, "El parámetro id necesita una descripción [description required], FAILED.");
        }
        elseif(!isset($postQuery->args()['id']['type']))
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo [type required], FAILED.");
        }
        elseif($postQuery->args()['id']['type'] != 'String!')
        {
            $this->assertTrue(false, "El parámetro id necesita un tipo entero no nulo [type required: string() nonnull], FAILED.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es correcto");
        }
    }


    /**
     * Función test modelo para probar el resultado de un Query.
     */
    public function testPostQuery()
    {
        $query = $this->query(
            new Query(
                'post',
                [
                    'id' => "5b7dabbbd686a57bb2307912"
                ],
                [
                    'id',
                    'user_id',
                    'title',
                    'body'
                ]
            )
        );

        $actual = json_encode($query);
        $expectedPostNull = json_encode(["post" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedPostNull))
        {
            // Esto muestra el Query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "El post no se ha mostrado (PostQuery FAILED), post null.");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra el Query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "El post no se ha mostrado (PostQuery FAILED), existen errores en los datos enviados.");
        }
        else
        {
            $this->assertTrue(true, "El post se han mostrado correctamente");
        }

    }

}
