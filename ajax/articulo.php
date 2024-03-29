<?php

require_once '../modelos/Articulo.php';

$articulo = new Articulo();

$idarticulo = isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idcategoria = isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$codigo = isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock = isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$descripcion = isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen = isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";


switch ($_GET['op'])
{
    case 'guardaryeditar':
        if (!file_exists($_FILES['imagen']["tmp_name"]) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
        {
            $imagen = $_POST["imagenActual"];
        }else
        {
            $ext = explode(".",$_FILES['imagen']['name']);
            if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
            {
                $imagen = round(microtime(true)). '.' . end($ext);
                move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/articulos/".$imagen);
            }
        }
        if (empty($idarticulo))
        {
            $rspta = $articulo->ingresar($idcategoria,$codigo,$nombre,$stock, $descripcion,$imagen);
            echo $rspta?"se ha ingresado datos": "error al ingresar datos";
        }else
        {
            $rspta = $articulo->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock, $descripcion,$imagen);
            echo $rspta?"se ha actualizado": "error al actualizar";
        }
        break;
    case 'desactivar':
        $rspta = $articulo->desactivar($idarticulo);
        echo $rspta?"se ha desactivado":"error al desactivar";
        break;
    case'activar':
        $rspta = $articulo->activar($idarticulo);
        echo $rspta?"se ha activado":"error al activar";
        break;
    case 'mostrar':
        $rspta = $articulo->mostrar($idarticulo);
        echo json_encode($rspta);
        break;
    case 'listar':
        $rspta = $articulo->listar();
        $data = array();
        while ($reg = $rspta->fetch_object())
        {
            $data[]= array(
                "0"=> ($reg->condicion)?
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
                "1"=> $reg->nombre,
                "2"=> $reg->categoria,
                "3"=> $reg->codigo,
                "4"=> $reg->stock,
                "5"=> "<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
                "6"=> ($reg->condicion)? '<span class="label bg-green">Activado</span>' :'<span class="label bg-red">Desactivado</span>',
            );
        }
        $result = array(
            "seEcho"=>1, //Informacion para el data tables
            "iTotalRecords" =>count($data), //enviamos el total de registros al tadatables
            "iTotalDisplayRecords" =>count($data), // enviamos el total registro a visualizar
            "aaData" => $data);
        echo json_encode($result);
        break;
    case 'selectCategoria':
        require_once '../modelos/Categoria.php';
        $categoria = new Categoria();
        $rspta = $categoria->select();

        while ($reg = $rspta->fetch_object())
        {
            echo'
                <option value='.$reg->idcategoria.' >'.$reg->nombre.'</option>
            ';
        }
        break;
}