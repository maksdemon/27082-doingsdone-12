<!DOCTYPE html>
<html lang="ru">
<body>
<h1 class="visually-hidden">Дела в порядке</h1>
<div class="page-wrapper">
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
                                <span
                                    class="main-navigation__list-item-count"><?= tasks_count($all_user_tasks, $user_project['id']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <a class="button button--transparent button--plus content__side-button" href="form-project.php">Добавить проект</a>
            </section>
            <main class="content__main">
                <h2 class="content__main-heading">Добавление задачи</h2>
                <form class="form" action="/add.php" method="post" enctype="multipart/form-data" autocomplete="off">
                    <div class="form__row">
                        <label class="form__label" for="name">Название <sup>*</sup></label>
                        <input class="form__input" type="text" name="name" id="name" value="<?= $task_name ?>"
                               placeholder="Введите название">
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                            <p class='form__message'><?= isset($errors['task_name']) ? $errors['task_name'] : '' ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="project">Проект <sup>*</sup></label>
                        <select class="form__input form__input--select" name="project" id="project">
                            <?php foreach ($user_projects as $user_project): ?>
                                <option value="<?= $user_project["id"] ?> "> <?= $user_project['title'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="date">Дата выполнения</label>
                        <input class="form__input form__input--date" type="text" name="date" id="date" value=""
                               placeholder="Введите дату в формате ГГГГ-ММ-ДД">
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                            <p class='form__message'><?= isset($errors['date']) ? $errors['date'] : '' ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="file">Файл</label>
                        <div class="form__input-file">
                            <input class="visually-hidden" type="file" name="file" id="file" value="">
                            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                                <p class='form__message'><?= isset($errors['file']) ? $errors['file'] : '' ?></p>
                            <?php endif; ?>
                            <label class="button button--transparent" for="file">
                                <span>Выберите файл</span>
                            </label>
                        </div>
                    </div>
                    <div class="form__row form__row--controls">
                        <input class="button" type="submit" name="send" value="Добавить">
                    </div>
                </form>
            </main>
        </div>
    </div>
</div>
<script src="../flatpickr.js"></script>
<script src="../script.js"></script>
</body>
</html>
