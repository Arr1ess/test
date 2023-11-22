<div class="card">
    <div class="card__image-container">
        <img src="/LR2/IMG/<?php echo $photo; ?>" alt="Фото" class="card__image">
    </div>
    <p class="card__info"><span class="card__label">Название:</span>
        <?php echo $name; ?>
    </p>
    <p class="card__info"><span class="card__label">Состав:</span>
        <?php echo $composition; ?>
    </p>
    <p class="card__info"><span class="card__label">Вес:</span>
        <?php echo $weight; ?>
    </p>
    <p class="card__info"><span class="card__label">ID меню:</span>
        <?php echo $menuName; ?>
    </p>
</div>


<style>
    .card {
        width: calc(50% - 10px);
        background-color: #f5f5f5;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .card__image-container {
        text-align: center;
        margin-bottom: 10px;
    }

    .card__image {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .card__info {
        margin: 10px 0;
    }

    .card__label {
        font-weight: bold;
        margin-right: 10px;
    }
</style>