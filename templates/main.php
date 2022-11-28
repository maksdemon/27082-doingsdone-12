<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($type_project as $typ): ?>
                <li class="main-navigation__list-item
                    <?php if (isset($typ["id"]) && intval($typ["id"]) === intval($_GET["id"])): ?>
                        main-navigation__list-item--active
                    <?php endif; ?>">
                    <a class="main-navigation__list-item-link" href="/?id=<?= $typ['id']; ?>"><?= htmlspecialchars($typ['title']);  ?></a>
                    <span class="main-navigation__list-item-count"><?= test_count( $task_count_oll1,$typ['title'])  ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="add_project.php" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="/" method="get" autocomplete="off">
        <label>
            <input class="search-form__input" type="text" name="q" value=" <?=trim(filter_input(INPUT_GET, 'q')) ?>" placeholder="Поиск по задачам">
        </label>

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>




    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks ==1):?>checked <?php endif; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    <table class="tasks">

        <!--<?php if ($show_complete_tasks == 1) : ?>
            <tr class="tasks__item task task--completed
                 <?php if ( $test = (strtotime ($test['deadline'])-time())<86400): ?>
                    task--important
                <?php endif; ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text">Записаться на интенсив "Базовый PHP"</span>
                    </label>
                </td>
                <td class="task__date">10.10.2019</td>

                <td class="task__controls">
                </td>
            </tr>
        <?php endif ?>-->
        <!-- my test/*

        -->

        <!--  //вывод самого списка задач-->


        <?php foreach ($task_c_name as  $test):{
            if ($show_complete_tasks == 0 && $test['status']== 'false'){
                continue;
            }
            else{

            }
        }

            ?>

            <tr class="tasks__item task
                            <?php if ($test['status']== 'true') : ?>
                                task--completed
                            <?php endif ?>
				             <?php if ( date_diff3($test['deadline']) <=24): ?>
                                task--important
                            <?php endif; ?>

">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1" >
                        <span class="checkbox__text"><?= htmlspecialchars ($test['name']);  ?></span>
                    </label>
                </td>
                <td class="task__file">

                    <?php if (isset($test['file'])): ?>
                        <a class="download-link" href="<?= "/uploads/".$test['file']; ?>">
                            <?= $test['file']; ?>
                        </a>
                    <?php endif; ?>



                </td>
                <td class="task__date">
                    <?=
                    date("d.m.Y", strtotime($test["deadline"]));
                    ?>

                </td>
            </tr>
        <?php endforeach; ?>
        <p class="error-message"><?= $errorsearch2 ?></p>

    </table>
</main>






