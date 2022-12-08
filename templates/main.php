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


            <a href="/?filter=all<?=(isset($id_task_showid))?>" class="tasks-switch__item <?php if ($id_task_time == 'all' || $id_task_time == '') : ?>
                        tasks-switch__item--active<?php endif;?>">Все задачи</a>




            <a href="/?filter=today" class="tasks-switch__item   <?php if ($id_task_time == 'today') : ?>
                          tasks-switch__item--active<?php endif;?>">Повестка дня</a>

            <a href="/?filter=tommorow" class="tasks-switch__item <?php if ($id_task_time == 'tommorow') : ?>
                            tasks-switch__item--active <?php endif;?>">Завтра</a>

            <a href="/?filter=expired" class="tasks-switch__item <?php if ($id_task_time == 'expired') : ?>
                            tasks-switch__item--active<?php endif;?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks ==1):?>checked <?php endif; ?>>


            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>
    <table class="tasks">

        <?php foreach ($task_c_name as  $test):{
            if ($show_complete_tasks == 0 && $test['STATUS']== 'false'){
                continue;
            }
            else{

            }
        }

            ?>
            <tr class="tasks__item task
                            <?php if ($test['STATUS'] == '1') : ?>
                                task--completed
                            <?php endif; ?>
				             <?php if ( date_diff3($test['deadline']) <=24): ?>
                                task--important
                            <?php endif; ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?=$test['id']?>" >
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






