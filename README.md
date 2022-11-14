## Documentación de la API de la cafetería ‘Gulp!’

Esta API tiene como fin poder visualizar los productos ofrecidos en ‘Gulp!’, y las opiniones emitidas por los clientes, así como también se podrán agregar, modificar y eliminar opiniones.

### Los endpoints de los métodos GET, son los siguientes:
  ```
    GET      api/products                  Lista todos los productos disponibles.
    GET      api/products/opinions         Lista las opiniones de todos los productos.
    GET      api/products/opinions/:ID     Muestra una opinión seleccionada por su ID.
  ```
### Método y endpoint POST:
  ```
    POST     api/products
  ```
Deberán completarse ambos campos para que la opinión sea agregada, ejemplo de los campos a completar:
  ```
    {
    "opinion": "Aquí irá su opinión",
    "id_producto": "Aquí irá el id del producto del cual desea emitir una opinión"
    }
  ```
El ID del producto podrá encontrarlo en el listado de productos.

### Método y endpoint PUT:
  ```
    PUT     api/products/opinions/:ID
  ```
Podrá elegir qué campo modificar: 
  ```
    {
    "opinion": "Aquí irá su opinión",
    "id_producto": "Aquí irá el id del producto del cual desea emitir una opinión"
    }
  ```
### Método y endpoint DELETE:
  ```
    DELETE     api/products/opinions/:ID
  ```
La opinión seleccionada por su ID será eliminada.


## Filtros

Tanto los productos como las opiniones podrán ser filtradas por cualquiera de sus campos, por ejemplo:

Para obtener los productos que sean de la categoría 'Café', nuestra URL tendrá la siguiente forma:

  ```
    api/products?filterColumn=id_categoria&filterValue=1
  ```   
Tanto el campo que elija y el valor del mismo podrá encontrarlo en el listado de productos.

Para obtener las opiniones de un producto determinado, nuestra URL tendrá la siguiente forma:

  ```
    api/products/opinions?filterColumn=id_producto&filterValue=1
  ``` 
Tanto el campo que elija y el valor del mismo podrá encontrarlo en el listado de opiniones.

## Ordenamiento

Tanto los productos como las opiniones podrán ser ordenados de manera ascendente o descendente por cualquiera de sus campos, por ejemplo:

Para ordenar los productos de manera 'Descendente' por el campo 'id_producto', nuestra URL tendrá la siguiente forma:

  ```
    api/products?sort=id_producto&order=desc
  ```

Para ordenar las opiniones de manera 'Descendente' por el campo 'id_opinion', nuestra URL tendrá la siguiente forma:

  ```
    api/products/opinions?sort=id_opinion&order=desc
  ```
## Filtro y ordenamiento juntos

Tanto los productos como las opiniones podrán ser filtradas y ordenadas a la vez, por ejemplo:

Para obtener los productos filtrados por el campo 'id_categoria' y ordenados de manera 'Descendente' por el campo 'id_producto', nuestra URL tendrá la siguiente forma:

  ```
    api/products?filterColumn=id_categoria&filterValue=1&sort=id_producto&order=desc
  ```










