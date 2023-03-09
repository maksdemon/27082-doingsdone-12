<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
<h1 class="visually-hidden">Дела в порядке</h1>

<div class="page-wrapper">
    <div class="container container--with-sidebar">


        <div class="content">
            <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                        <?php
                        foreach ($type_project as $typ): ?>
                            <li class="main-navigation__list-item
                    <?php
                            if (isset($typ["id"]) && intval($typ["id"]) === intval($_GET["id"])): ?>
                        main-navigation__list-item--active
                    <?php
                            endif; ?>">


                                <a class="main-navigation__list-item-link"
                                   href="/?id=<?= $typ['id']; ?>"><?= htmlspecialchars($typ['title']); ?></a>
                                <span class="main-navigation__list-item-count"><?= test_count(
                                        $task_count_oll1,
                                        $typ['title']
                                    ) ?></span>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button" href="add_project.php">Добавить
                    проект</a>
            </section>

            <main class="content__main">
                <h2 class="content__main-heading">Добавление проекта</h2>

                <form class="form" action="add_project.php" method="post" autocomplete="off">
                    <div class="form__row">
                        <label class="form__label" for="name">Название <sup>*</sup></label>

                        <input class="form__input" type="text" name="name" id="project_name" value=""
                               placeholder="Введите название проекта">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                            <p class='form__message'><?= $errors['$tsql_name'] ?></p>
                        <?php
                        endif; ?>
                    </div>

                    <div class="form__row form__row--controls">
                        <input class="button" type="submit" name="" value="Добавить">
                    </div>
                </form>
            </main>
        </div>
    </div>
</div>

<footer class="main-footer">

</footer>
</body>
</html>
