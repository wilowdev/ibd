<?php

namespace Ibd;

class Uzytkownicy
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
     * Dodaje użytkownika do bazy.
     * 
     * @param array  $dane
     * @param string $grupa
     * @return int
     */
    public function dodaj(array $dane, string $grupa = 'użytkownik'): int
    {
        return $this->db->dodaj('uzytkownicy', [
            'imie' => $dane['imie'],
            'nazwisko' => $dane['nazwisko'],
            'adres' => $dane['adres'],
            'telefon' => $dane['telefon'],
            'email' => $dane['email'],
            'login' => $dane['login'],
            'haslo' => password_hash(($dane['haslo']), PASSWORD_BCRYPT),
            'grupa' => $grupa
        ]);
    }

    /**
     * Loguje użytkownika do systemu. Zapisuje dane o autoryzacji do sesji.
     *
     * @param string $login
     * @param string $haslo
     * @param string $grupa
     * @return bool
     */
    public function zaloguj(string $login, string $haslo, string $grupa): bool
    {

        $dane = $this->db->pobierzWszystko(
            "SELECT uz.haslo, uz.login, uz.grupa, uz.id FROM uzytkownicy uz WHERE login = :login AND grupa = '$grupa'", ['login' => $login]
        );


        if (password_verify($haslo, $dane[0]['haslo'])) {
            $_SESSION['id_uzytkownika'] = $dane[0]['id'];
            $_SESSION['grupa'] = $dane[0]['grupa'];
            $_SESSION['login'] = $dane[0]['login'];

            return true;
        }

        return false;
    }

    //funkcje do sprawdzania obecnosci w bazie
    public function sprawdzLogin(string $login)
    {
        $sql = "SELECT * FROM uzytkownicy WHERE login = :login";
        $params = ['login' => $login];

        return $this->db->pobierzWszystko($sql, $params);
    }
    public function sprawdzEmail(string $email): ?array
    {
        $sql = "SELECT * FROM uzytkownicy WHERE email = :email";
        $params = ['email' => $email];

        return $this->db->pobierzWszystko($sql, $params);
    }
}
