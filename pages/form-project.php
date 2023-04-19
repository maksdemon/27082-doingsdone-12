<div class="container container--with-sidebar">
    <div class="content">
        <section class="content__side">
            <h2 class="content__side-heading">Проекты</h2>

            <nav class="main-navigation">
                <ul class="main-navigation__list">
                    <?php foreach ($user_projects as $user_project): ?>
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link"
                               href="/?id=<?= $user_project['id'] ?>"><?= htmlspecialchars($user_project['title']) ?></a>
                            <span class="main-navigation__list-item-count"><?= tasks_count($all_user_tasks, $user_project['id']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <a class="button button--transparent button--plus content__side-button" href="add_project.php">Добавить проект</a>
        </section>
        <main class="content__main">
            <h2 class="content__main-heading">Добавление проекта</h2>
            <form class="form" action="add_project.php" method="post" autocomplete="off">
                <div class="form__row">
                    <label class="form__label" for="name">Название <sup>*</sup></label>
                    <input class="form__input" type="text" name="name" id="project_name" value=""
                           placeholder="Введите название проекта">
                    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                        <p class='form__message'><?= $error_message ?></p>
                    <?php endif; ?>
                </div>
                <div class="form__row form__row--controls">
                    <input class="button" type="submit" name="" value="Добавить">
                </div>
            </form>
        </main>
    </div>
</div>
