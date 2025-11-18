<?php
//file: view/project/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$projects = $view->getVariable("projects");
$currentuser = $view->getVariable("currentusername");

$view->setVariable("title", "Projects");

?><?php if (isset($currentuser)): ?>
    
<?php else: ?>
    <p>Aplicación para la gestión colaborativa de tareas por proyectos</p>

    <section>
        <h2>Resumen de funciones</h2>
        <ul>
            <li>Registrarse e iniciar sesión</li>
            <li>Crear y listar proyectos</li>
            <li>Crear, editar, eliminar y marcar tareas</li>
            <li>Añadir usuarios a proyectos</li>
        </ul>
    </section>
<?php endif ?>
