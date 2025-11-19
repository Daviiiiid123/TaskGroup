<?php
//file: view/project/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();
$view->setFragment("css", '<link rel="stylesheet" href="view/styles/projects.css">');

$projects = $view->getVariable("projects");
$currentuser = $view->getVariable("currentusername");

?><?php if (isset($currentuser)): $view->setVariable("title", i18n("Projects"));?>
    <h1><?php echo i18n("Projects"); ?></h1>

    <?php if (count($projects) == 0): ?>
        <p><?php echo i18n("You have no projects. Create a new project to get started!"); ?></p>
    <?php else: ?>
        <ul>
            <?php foreach ($projects as $project): ?>
                <li>
                    <a href="index.php?controller=project&action=view&id=<?php echo $project->getId(); ?>">
                        <?php echo htmlspecialchars($project->getTitle()); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <a href="index.php?controller=project&action=create" class="btn btn-primary">
        <?php echo i18n("Create New Project"); ?>
    </a>


    
<?php else: $view->setVariable("title", i18n("Index"));?>
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
