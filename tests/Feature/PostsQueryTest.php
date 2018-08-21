<?php

namespace Tests\Feature;

use Illuminate\Contracts\Console\Kernel;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use KunicMarko\GraphQLTest\Bridge\Laravel\TestCase;
use KunicMarko\GraphQLTest\Operation\Query;

use App\GraphQL\Query\PostsQuery;

class PostsQueryTest extends TestCase
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
        $postsQuery = new PostsQuery();
        if($postsQuery->type() != '[PostType]')
        {
            $this->assertTrue(false, "El tipo debe ser una lista de PostType.");
        }
        else
        {
            $this->assertTrue(true, "El tipo es una lista de PostType.");
        }

    }


    /**
     * Función test modelo para probar los argumentos de un Query.
     */
    public function testArgs()
    {
        $postsQuery = new PostsQuery();

        if(sizeof($postsQuery->args()) > 0)
        {
            $this->assertTrue(false, "Esta Query no espera parámetros, FAILED.");
        }
        else
        {
            $this->assertTrue(true, "Se ejecutó correctamente");
        }
    }


    /**
     * Función test modelo para probar el resultado de un Query.
     */
    public function testPostsQuery(): void
    {
        $query = $this->query(
            new Query(
                'posts',
                [],
                [
                    'id',
                    'user_id',
                    'title',
                    'body'
                ]
            )
        );

        $actual = json_encode($query);
        $expectedPostNull = json_encode(["posts" => null]);
        $expectedErrors = json_encode("errors");

        if(Str::contains($actual, $expectedPostNull))
        {
            // Esto muestra la query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "Los posts no se ha mostrado (PostsQuery FAILED), posts null.");
        }
        elseif (Str::contains($actual, $expectedErrors))
        {
            // Esto muestra la query que se está listando...
            echo json_encode($query);
            $this->assertTrue(false, "Los posts no se ha mostrado (PostsQuery FAILED), existen errores en los datos enviados.");
        }
        else
        {
            $this->assertTrue(true, "Los posts se han mostrado correctamente");
        }
    }
}
