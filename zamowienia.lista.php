<?php
include 'header.php';

use Ibd\Zamowienia;
use Ibd\Stronicowanie;

$zamowienia = new Zamowienia();
if($_SESSION == null){

} else{
    $lista = $zamowienia ->pobierzZamowienia();
}

?>

    <h1>Zamówienia</h1>

    <table class="table table-striped table-condensed" id="ksiazki">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Zamowienie</th>
            <th>Status</th>
            <th>Klient</th>
            <th>Wartość PLN</th>
            <th>Ilość Książek</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($_SESSION != null): ?>
        <?php foreach ($lista as $zamowienie): ?>
            <tr>
                <td></td>
                <td><?= $zamowienie['id'] ?></td>
                <td><?= $zamowienie['status'] ?></td>
                <td><?= $zamowienie['login'] ?>: <?= $zamowienie['imie'] ?> <?= $zamowienie['nazwisko'] ?></td>
                <td><?= $zamowienie['suma'] ?></td>
                <td><?= $zamowienie['liczba_ksiazek'] ?></td>
                <td>

                </td>
            </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8" style="text-align: center">Brak zamówień</td></tr>
        <?php endif; ?>
        </tbody>
    </table>


<?php include 'footer.php'; ?>