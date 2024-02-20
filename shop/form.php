<?php
require_once "functions/functions.php";
$tovar_form = getTovar()

?>
<?php require "blocks/header.php" ?>
<div class="content">
    <div class="content_2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="col-md-5" method="post">
            <?php echo $err['success'] ?>
            <div class="form-group">
                <label for="">Ваше имя</label>
                <input type="text" class="form-control" name="name" value="<?php echo $_POST['name'] ?>"
                    placeholder="Имя не более 10-ти символов">
                <?php echo $err['name'] ?>
            </div>

            <div class="form-group">
                <label for="">Телефон</label>
                <input type="text" class="form-control" name="phone" value="<?php echo $_POST['phone'] ?>"
                    placeholder="Номер телефона формата Украины">
                <?php echo $err['phone'] ?>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $_POST['email'] ?>"
                    placeholder="Emai адрес">
                <?php echo $err['email'] ?>
            </div>
            <div class="form-group">
                <label for="sel1">Название товара</label>
                <select class="form-control"  name="name_tovar" required>
                    <option disabled selected>Выберите товар</option>
                    <?php for($i=0; $i < count($tovar_form); $i++): ?>
                        <option value="<?php echo $tovar_form[$i]["title"]; ?><?php echo $_POST['name_tovar'] ?>"><?php echo $tovar_form[$i]["title"]; ?></option>
                    <?php endfor; ?>
                </select>
                <?php echo $err['name_tovar'] ?>
            </div>
            <div class="form-group">
                <label for="">Количество товара</label>
                <input type="number" step="1" class="form-control" name="num" value="<?php echo $_POST['num'] ?>"
                    placeholder="Минимум 1 | Максиимум 20">
                <?php echo $err['num'] ?>
            </div>
            <button type="submit" class="btn btn-success" name="submit">Отправить</button>
        </form>
    </div>
</div>
<?php require "blocks/foother.php" ?>