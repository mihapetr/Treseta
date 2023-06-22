# Ideje

## JSON u bazi podataka
* stanje igre će biti određeni objekt, npr. instanca klase `Stol` imena `stanje`
* kako bismo izbjegli object-relational mapping problematiku kod spremanja u bazu, možemo u neku tablicu staviti atribut čiji tip podatka je JSON i spremiti: `json_encode(stanje)`
* pitat ću profesora je li to ok, ali ne bi trebalo biti problema
* kod dohvata iz baze se samo dekodira JSON u objekt tipa `Stol`

## MVC

### Model
* sadrži klase `Karta, Stol, Igrac, Spil` ...

### View
* JavaScript isključivo u *view* modulu smije biti
* login
    * unos imena i pozicije koju korisnik želi igrati
* game 
    * glavni engine je JavaScript s Ajax upitima serveru
    * primjer upita

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

### Controller
* login
    * uz pomoć baza.class stvara novog igrača sa zahtjevanom pozicijom
* game
    * ovisno o Ajax upitu koristi *modelove* klase za obradu upita i šalje klijentu
    objektne odgovore u obliku JSON teksta
    * long polling paradigma


# Problemi
