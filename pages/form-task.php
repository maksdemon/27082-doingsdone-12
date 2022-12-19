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

        <a class="button button--transparent button--plus content__side-button" href="form-project.php">Добавить проект</a>
      </section>

      <main class="content__main">
        <h2 class="content__main-heading">Добавление задачи</h2>
          <!-- Название -->
        <form class="form"  action="/add.php" method="post" enctype="multipart/form-data" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="<?= $tsql_name ?>" placeholder="Введите название">
              <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                  <p class='form__message'><?= $errors['$tsql_name'] ?></p>
              <?php endif; ?>
          </div>

            <!-- Проект -->
          <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project2" id="project">

                <?php foreach ($type_project as $typ): ?>
                    <option value= "<?= $typ["id"] ?> "> <?= $typ['title'] ?></option>
                <?php endforeach; ?>

            </select>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value="" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
              <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                  <p class='form__message'><?= $errors['date'] ?></p>
              <?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">
                <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <p class='form__message'><?=   $errors['file'] ?></p>
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
