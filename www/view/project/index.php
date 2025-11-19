<?php
//file: view/project/index.php

require_once(__DIR__ . "/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$projects = $view->getVariable("projects");
$currentuser = $view->getVariable("currentusername");

// Cargar CSS adicional
$view->moveToFragment("css");
?>
<link rel="stylesheet" href="view/styles/projects.css">
<?php
$view->moveToDefaultFragment();

?><?php if (isset($currentuser)): $view->setVariable("title", i18n("Projects")); ?>
<h1><?php echo i18n("Projects"); ?></h1>

<?php if (count($projects) == 0): ?>
    <p><?php echo i18n("You have no projects. Create a new project to get started!"); ?></p>
<?php else: ?>
    <div class="project-list">
        <?php foreach ($projects as $project): ?>
            <a href="index.php?controller=project&action=view&id=<?php echo $project->getId(); ?>" class="project-card">
                <h3><?php echo htmlspecialchars($project->getTitle()); ?></h3>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<?php else: $view->setVariable("title", i18n("Index")); ?>
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