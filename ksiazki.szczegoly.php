<?php

// jesli nie podano parametru id, przekieruj do listy książek
if(empty($_GET['id'])) {
    header("Location: ksiazki.lista.php");
    exit();
}

$id = (int)$_GET['id'];

include 'header.php';

use Ibd\Ksiazki;

$ksiazki = new Ksiazki();
$dane = $ksiazki->pobierz($id);
?>
    <p>
        <a href="ksiazki.lista.php"><i class="fas fa-chevron-left"></i> Powrót</a>
    </p>
    <div class="row">
        <div class="col-4 p-1">
            <?php if (!empty($dane['zdjecie'])) : ?>
                <img src="zdjecia/<?= $dane['zdjecie'] ?>" alt="<?= $dane['tytul'] ?>" class="img-thumbnail" />
            <?php else : ?>
                brak zdjęcia
            <?php endif; ?>
        </div>
        <div class="col-8">
            <div class="table">
                <table>
                    <tr>
                        <td>
                            <h3> Tytuł: </h3>
                        </td>
                        <td>
                           <h3> <?= $dane['tytul'] ?> </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>Cena: </td>
                        <td>
                            <?= $dane['cena'] ?> zł
                        </td>
                    </tr>
                    <tr>
                        <td>Liczba stron: </td>
                        <td>
                            <?= $dane['liczba_stron'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ISBN: </td>
                        <td>
                            <?= $dane['isbn'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Opis: </td>
                        <td  class="text-justify">
                            <?= $dane['opis'] ?>
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>



<?php include 'footer.php'; ?>