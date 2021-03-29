<?php

namespace Ibd;

class Ksiazki
{
	/**
	 * Instancja klasy obsługującej połączenie do bazy.
	 *
	 * @var Db
	 */
	private Db $db;

	public function __construct()
    {
        $this->db = new Db();
	}

	/**
	 * Pobiera wszystkie książki.
	 *
	 * @return array
	 */
	public function pobierzWszystkie(): ?array
    {
		$sql = "SELECT ks.*, kat.nazwa, aut.imie, aut.nazwisko
                FROM ksiazki ks  
                    JOIN autorzy aut on ks.id_autora = aut.id
                    JOIN kategorie kat on ks.id_kategorii = kat.id
                ";

		return $this->db->pobierzWszystko($sql);
	}

    /**
     * Pobiera dane książki o podanym id.
     *
     * @param int $id
     * @return array
     */
	public function pobierz(int $id): ?array
    {
		return $this->db->pobierz('ksiazki', $id);
	}

	/**
	 * Pobiera najlepiej sprzedające się książki.
	 * 
	 */
	public function pobierzBestsellery(): ?array
	{
		$sql = "SELECT * FROM ksiazki ORDER BY RAND() LIMIT 5";


		return $this->db->pobierzBestsellery($sql);
	}

}
