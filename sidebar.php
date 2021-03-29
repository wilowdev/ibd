<?php

use Ibd\Ksiazki;

$ksiazki = new Ksiazki();
$bestseller = $ksiazki->pobierzBestsellery();

?>


<div class="col-md-2">
	<h1>Bestsellery</h1>

    <table class="table">
        <?php foreach ($bestseller as $bst) : ?>
            <tr>
                <td>
                    <a href="ksiazki.szczegoly.php?id=<?= $bst['id'] ?> " title="Szczegóły pozycji" class="text-dark">
                        <?php if (!empty($bst['zdjecie'])) : ?>
                            <img src="zdjecia/<?= $bst['zdjecie'] ?>" alt="<?= $bst['tytul'] ?>" class="img-thumbnail"/>
                        <?php else : ?>
                            brak zdjęcia
                        <?php endif; ?>
                        <p class="pl-2 pt-1">Tytuł: <?= $bst['tytul'] ?></p>
                        <p class="pl-2">Autor: <?= $bst['imie'] ?> <?= $bst['nazwisko'] ?></p>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>