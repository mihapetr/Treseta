# Generalno
* koristimo engleski za nazivlje unutar koda
* puno komentara bi bilo lijepo

# Ideje

## JSON u bazi podataka (prilagoditi stvarne nazive)
* stanje igre će biti određeni objekt, npr. instanca klase `Stol` imena `stanje`
* kako bismo izbjegli object-relational mapping problematiku kod spremanja u bazu, možemo u neku tablicu staviti atribut čiji tip podatka je JSON i spremiti: `json_encode(stanje)`
* pitat ću profesora je li to ok, ali ne bi trebalo biti problema
* kod dohvata iz baze se samo dekodira JSON u objekt tipa `Stol`

## Sinkronizacija poteza igrača
* u bazi podataka može postojati tablica :
```
create table State {
    who tinyint(1),     -- index of player to play
    object JSON          -- encoded data from a Table object running the game
}
```
* nakon što svaki od 4 klijenta napravi vezu sa serverom pomoću long-polling-a, server može u petlji svakih 10 ms provjeravati piše li u tablici Table u stupcu `who` indeks onoga koji je slao zahtjev
* u svakom trenutku za jedan od klijenata će to vrijediti i on može tada skinuti JSON i *dekodirati* ga u Table klasu, napraviti potez, završiti fazu, encode-ati Table objekt u JSON i spremiti u bazu podataka nove podatke pomoću `$table -> save()`
    * **problemčić** : potrebno je implementirati interpreter za JSON kod castanja u Table objekt nakon dohvata iz baze

## MVC

### App
* baza podataka sadrži detalje o kartama (jačina, vrijednost, ime slike)
```
create table Card {
    id int primary key,     -- auto increment
    strength tinyint(2),     -- 
    value tinyint(1),        -- how many belas it is worth, not punats
    suit char(1),           -- {c, d, s, b}
    image varchar(3)        -- distinct part of image name
};
```

* popunio sam Card tablicu u *petrinjak* bazi
* treba postojati još jedna 

### Model
* radim na modelu
* sadrži klase `Collection, Deck, Hand, Pile, Player, Card` ...

### View
* JavaScript isključivo u *view* modulu smije biti
* login
    * unos imena i pozicije koju korisnik želi igrati
* game 
    * glavni engine je JavaScript s Ajax upitima serveru
    * primjer upita:

```
$.ajax({
        url : "index.php?rt=<ime_kontrolera>/<metoda_kontrolera>",
        data : {
            // neki podaci bitni za upit
        },
        method : "POST",
        dataType : "json",  // automatski parse kod pridruživanja varijabli
        success : obradi_odgovor    // ime funkcije s jednim parametrom
    });
```

* svi Ajax upiti idu preko *index.php* routera nekom controlleru
* u datoteci handTest.php je osim modela ruke testiran i mogući izgled karata
    * korišteni su zaobljeni rubovi da se ne vide ostaci zaobljenih rubova sa slika karata
    * stavljen je 1px solid black border
    * **treba prilagoditi mjerne jedinice tako da se prilagođavaju dimenzijama ekrana**

### Controller
* login
    * uz pomoć baza.class stvara novog igrača sa zahtjevanom pozicijom
* game
    * ovisno o Ajax upitu koristi *modelove* klase za obradu upita i šalje klijentu
    objektne odgovore u obliku JSON teksta
    * long polling paradigma (probably)

# Problemi

## image cash
* cashiraju li se slike nakon inicijalnog učitavanja?
