import { seleccionarProductos } from "../models/productos";

// objetos del DOM //
const listado = document.querySelector('#listado');

// variables y constantes generales
let productos = [];
let producto = {};
/**
 * metodo que se ejecuta
 * cuando carga la pagina
 */

document.addEventListener('DOMContentLoaded', ()=> {
    mostrarProductos() ;
}) 
/**
 * metodo para mostrar los productos 
 */
async function mostrarProductos (){
    productos = await seleccionarProductos();
    listado.innerHTML = '';
    productos.map(producto => { 
        listado.innerHTML += `
                <div class="col">
                    <div class="card" style="width: 18rem;">
                        <img src="./productos/${producto.imagen}" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">${producto.codigo} - ${producto.nombre}</h5>
                          <p class="card-text">${producto.descripcion}</p>
                          <a href="#" class="btn btn-primary">Ver más</a>
                        </div>
                      </div>
                </div>    
      ` ;
    })
}
