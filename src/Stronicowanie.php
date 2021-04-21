<?php

namespace Ibd;

class Stronicowanie
{
    /**
     * Instancja klasy obsługującej połączenie do bazy.
     *
     * @var Db
     */
    private $db;

    /**
     * Liczba rekordów wyświetlanych na stronie.
     *
     * @var int
     */
    private $naStronie = 5;

    /**
     * Aktualnie wybrana strona.
     *
     * @var int
     */
    private $strona = 0;

    /**
     * Dodatkowe parametry przekazywane w pasku adresu (metodą GET).
     *
     * @var array
     */
    private $parametryGet = [];

    /**
     * Parametry przekazywane do zapytania SQL.
     *
     * @var array
     */
    private $parametryZapytania;

    public function __construct($parametryGet, $parametryZapytania)
    {
        $this->db = new Db();
        $this->parametryGet = $parametryGet;
        $this->parametryZapytania = $parametryZapytania;

        if (!empty($parametryGet['strona'])) {
            $this->strona = (int)$parametryGet['strona'];
        }
    }

    /**
     * Dodaje do zapytania SELECT klauzulę LIMIT.
     *
     * @param string $select
     * @return string
     */
    public function dodajLimit(string $select): string
    {
        return sprintf('%s LIMIT %d, %d', $select, $this->strona * $this->naStronie, $this->naStronie);
    }

    /**
     * Generuje linki do wszystkich podstron.
     *
     * @param string $select Zapytanie SELECT
     * @param string $plik Nazwa pliku, do którego będą kierować linki
     * @return string
     */
    public function pobierzLinki(string $select, string $plik): string
    {
        $rekordow = $this->db->policzRekordy($select, $this->parametryZapytania);
        $liczbaStron = ceil($rekordow / $this->naStronie);
        $parametry = $this->_przetworzParametry();
        $linki = "<nav><ul class='pagination justify-content-center'>";
        //dodanie poprzednia i pierwsza z warunkami
        if (0 == $this->strona) {
            $linki .= "<li class='page-item disabled'><a class='page-link' href=''><<</a></li>";
            $linki .= "<li class='page-item disabled'><a class='page-link' href=''><</a></li>";
        } else {
            $linki .= sprintf(
                "<li class='page-item'><a href='%s?%s&strona=%d' title='Początek' class='page-link'><<</a></li>",
                $plik,
                $parametry,
                0
            );
            $linki .= sprintf(
                "<li class='page-item'><a href='%s?%s&strona=%d' title='Poprzednia' class='page-link'><</a></li>",
                $plik,
                $parametry,
                ($this->strona)-1
            );
        }

        for ($i = 0; $i < $liczbaStron; $i++) {
            if ($i == $this->strona) {
                $linki .= sprintf("<li class='page-item active'><a class='page-link'>%d</a></li>", $i + 1);
            } else {
                $linki .= sprintf(
                    "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link'>%d</a></li>",
                    $plik,
                    $parametry,
                    $i,
                    $i + 1
                );
            }
        }
        if ($liczbaStron-1 == $this->strona) {
            $linki .= "<li class='page-item disabled'><a class='page-link' href=''>></a></li>";
            $linki .= "<li class='page-item disabled'><a class='page-link' href=''>>></a></li>";
        } else {
            $linki .= sprintf(
                "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link' title='Następna'>></a></li>",
                $plik,
                $parametry,
                ($this->strona)+1
            );
            $linki .= sprintf(
                "<li class='page-item'><a href='%s?%s&strona=%d' class='page-link' title='Koniec'>>></a></li>",
                $plik,
                $parametry,
                $liczbaStron-1
            );
        }
        $linki .= "</ul></nav>";
        if (0 == $rekordow) {
            $pierwszyRekordStrony = $rekordow;
            $ostatniRekordStrony = $rekordow;
        } elseif ($this->strona == $liczbaStron-1){
            $pierwszyRekordStrony = $rekordow + 1 - $rekordow%$this->naStronie;
            $ostatniRekordStrony = $rekordow;
        } else{
            $ostatniRekordStrony = ($this->strona +1) * $this->naStronie;
            $pierwszyRekordStrony = $ostatniRekordStrony - ($this->naStronie - 1);
        }

        $linki .= sprintf(
            "</br><p>Wyświetlono $pierwszyRekordStrony - $ostatniRekordStrony z $rekordow rekordów.</p>",
            $plik,
            $parametry,
            $liczbaStron-1
        );

        return $linki;
    }

    /**
     * Przetwarza parametry wyszukiwania.
     * Wyrzuca zbędne elementy i tworzy gotowy do wstawienia w linku zestaw parametrów.
     *
     * @return string
     */
    private function _przetworzParametry(): string
    {
        $temp = [];
        $usun = ['szukaj', 'strona'];
        foreach ($this->parametryGet as $kl => $wart) {
            if (!in_array($kl, $usun))
                $temp[] = "$kl=$wart";
        }

        return implode('&', $temp);
    }
}
