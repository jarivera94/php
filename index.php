<?php
        require 'vendor/autoload.php';

       /* $c = new \Slim\Container(); //Create Your container

        //Override the default Not Found Handler before creating App
        $c['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {
                return $response->withStatus(404)
                    ->withHeader('Content-Type', 'text/html')
                    ->write('Page not found');
            };
	};*/
        $app = new \Slim\Slim();
	
	$db = new mysqli('localhost','root','Colombia18*','api_angular');

	$app->get("/health",function() use ($db,$app){
		var_dump($db);
                echo "Good ! from Slim ";
        } );

	//Guardar los productos
	$app->post("/productos",function() use ($db,$app){

		//Capturar informacion del request
		$json =$app->request->post("json");
		$data =json_decode($json,true);

		//var_dump($json);
		//var_dump($data);
		if(!isset($data['iamgen'])) $data["imagen"]=null;
		$query ="INSERT INTO productos VALUES(NULL,
			'{$data['nombre']}',
			'{$data['descripcion']}',
			'{$data['precio']}',
			'{$data['imagen']}')";
		$insert = $db->query($query);
		if($insert){
			$result = array(
				'status'=>'succes',
				'code'=>'200',
				'message'=>'Producto creado correctamente'

			);
		}else{
			$result = array(
                                'status'=>'succes',
                                'code'=>'400',
                                'message'=>'Producto no creado'

                        );
		}

		echo json_encode($result);
	});
	
	//Listar todos los productos
	$app->get("/productos", function () use ($db,$app){
		$sql ="SELECT * FROM productos ORDER BY id DESC";
		$query = $db->query($sql);
		
		$productos = array();
		while($producto =$query->fetch_assoc()){
			$productos[]=$producto;
		}

		 $result = array(
                                'status'=>'succes',
                                'code'=>'200',
                                'message'=>$productos

                        );

		echo json_encode($result);
	});

	//Construir productos 
	$app->get("/productos/:id",function($id) use($db,$app){
	
		$sql = "SELECT * FROM productos WHERE id ='{$id}'";
		$query = $db->query($sql);


		if($query->num_rows==1){
			$producto = $query->fetch_assoc();
			$result = array(
                                'status'=>'succes',
                                'code'=>'200',
                                'message'=>$producto

                        );
		}else{
			$result = array(
                                'status'=>'succes',
                                'code'=>'400',
                                'message'=>'Producto no disponible'
                        );

		}
		echo json_encode($result);

	});

	//Eliminar un producto
	$app->delete("/productos/:id",function ($id) use ($db,$app){
		$sql ="DELETE FROM productos WHERE id ='{$id}'";
		$delete = $db->query($sql);
		if($delete){
                        $result = array(
                                'status'=>'succes',
                                'code'=>'200',
                                'message'=>'Producto eliminado correctamente'

                        );
                }else{
                        $result = array(
                                'status'=>'succes',
                                'code'=>'400',
                                'message'=>'Producto no eliminado'

                        );
                }

                echo json_encode($result);

	});
	

	//Actualizar producto
	$app->put("/productos/:id",function ($id) use ($db, $app){
		
		$json = $app->request->put('json');
		$data=json_decode($json,true);


               // var_dump($json);
               // var_dump($data);
                if(!isset($data['iamgen'])) $data["imagen"]=null;
               $query ="UPDATE productos SET
                        nombre='{$data['nombre']}',
                        descripcion='{$data['descripcion']}',
                        precio='{$data['precio']}',
                        imagen='{$data['imagen']}' WHERE id = '{$id}'";
		$insert = $db->query($query);
		
                if($insert){
                        $result = array(
                                'status'=>'succes',
                                'code'=>'200',
                                'message'=>'Producto actualizado correctamente'

                        );
                }else{
                        $result = array(
                                'status'=>'succes',
                                'code'=>'400',
                                'message'=>'Producto no actualizado'

                        );
                }

		echo json_encode($result);
	
	});
	
	$app->run();

